<?php

namespace Magenest\Movie\Model;

use Exception;
use Magenest\Movie\Api\BlogRepositoryInterface;
use Magenest\Movie\Api\Data\BlogInterface;
use Magenest\Movie\Api\Data\BlogInterfaceFactory;
use Magenest\Movie\Api\Data\BlogSearchResultsInterface;
use Magenest\Movie\Api\Data\BlogSearchResultsInterfaceFactory;
use Magenest\Movie\Model\Blog\IdentityMap;
use Magenest\Movie\Model\ResourceModel\Blog as ResourceBlog;
use Magenest\Movie\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Throwable;

class BlogRepository implements BlogRepositoryInterface
{

    /**
     * @var ResourceBlog
     */
    protected $resource;

    /**
     * @var BlogFactory
     */
    protected $blogFactory;

    /**
     * @var BlogCollectionFactory
     */
    protected $blogCollectionFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var BlogSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;
    /**
     * @var BlogInterfaceFactory
     */
    protected $dataBlogFactory;
    /**
     * @var IdentityMap
     */
    private $identityMap;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceBlog $resource
     * @param BlogFactory $blogFactory
     * @param BlogInterfaceFactory $dataBlogFactory
     * @param BlogCollectionFactory $blogCollectionFactory
     * @param BlogSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param IdentityMap|null $identityMap
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        ResourceBlog                      $resource,
        BlogFactory                       $blogFactory,
        BlogInterfaceFactory              $dataBlogFactory,
        BlogCollectionFactory             $blogCollectionFactory,
        BlogSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper                  $dataObjectHelper,
        DataObjectProcessor               $dataObjectProcessor,
        StoreManagerInterface             $storeManager,
        ?IdentityMap                      $identityMap = null,
        CollectionProcessorInterface      $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->blogFactory = $blogFactory;
        $this->dataBlogFactory = $dataBlogFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->identityMap = $identityMap ?? ObjectManager::getInstance()
            ->get(IdentityMap::class);
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    private function getCollectionProcessor()
    {
        //phpcs:disable Magento2.PHP.LiteralNamespaces
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = ObjectManager::getInstance()->get(
                'Magento\Cms\Model\Api\SearchCriteria\BlockCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(BlogInterface $blog)
    {
        try {
            $blogId = $blog->getId();
            if ($blog->getStoreId() === null) {
                $storeId = $this->storeManager->getStore()->getId();
                $blog->setStoreId($storeId);
            }
            //         $this->validateLayoutUpdate($blog);
            $this->validateRoutesDuplication($blog);  //xem trung nhau cua url_rewrite
            $this->resource->save($blog);
            $this->identityMap->add($blog);
        } catch (LocalizedException $exception) {
            throw new CouldNotSaveException(
                __('Could not save the movie: %1', $exception->getMessage()),
                $exception
            );
        } catch (Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the movie: %1', __('Something went wrong while saving the movie.')),
                $exception
            );
        }
        return $blog;
    }

    /**
     * Validate new layout update values.
     *
     * @param BlogInterface $blog
     * @return void
     * @throws CouldNotSaveException
     */

    // xet url_rewrite khac nhau
    private function validateRoutesDuplication($blog): void
    {
        $collection = $this->blogCollectionFactory->create()->addFieldToFilter('url_rewrite', ['eq' => $blog->getUrlRewrite()]);

        if ($blog->getId()) {
            $collection->addFieldToFilter('id', ['neq' => $blog->getId()]);
        }
        if (count($collection->getItems())) {
            throw new CouldNotSaveException(
                __('The value specified in the UrlRewrite field would generate a URL that already exists.')
            );
        }
    }

    /**
     * Load Movie data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return BlogSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->blogCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Movie by given Movie Identity
     *
     * @param string $blogId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($blogId)
    {
        return $this->delete($this->getById($blogId));
    }

    /**
     * Delete Movie
     *
     * @param BlogInterface $blog
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog)
    {
        try {
            $this->resource->delete($blog);
            $this->identityMap->remove($blog->getId());
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the page: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Load Movie data by given Movie Identity
     *
     * @param string $blogId
     * @return Blog
     * @throws NoSuchEntityException
     */
    public function getById($blogId)
    {
        $blog = $this->blogFactory->create();
        $blog->load($blogId);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('The CMS page with the "%1" ID doesn\'t exist.', $blogId));
        }

        return $blog;
    }
}
