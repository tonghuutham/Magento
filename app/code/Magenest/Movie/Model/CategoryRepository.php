<?php

namespace Magenest\Movie\Model;

use Exception;
use Magenest\Movie\Api\CategoryRepositoryInterface;
use Magenest\Movie\Api\Data\CategoryInterface;
use Magenest\Movie\Api\Data\CategoryInterfaceFactory;
use Magenest\Movie\Api\Data\CategorySearchResultsInterface;
use Magenest\Movie\Api\Data\CategorySearchResultsInterfaceFactory;
use Magenest\Movie\Model\Category\IdentityMap;
use Magenest\Movie\Model\ResourceModel\Category as ResourceCategory;
use Magenest\Movie\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
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

class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * @var ResourceCategory
     */
    protected $resource;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryCollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var CategorySearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;
    /**
     * @var CategoryInterfaceFactory
     */
    protected $dataCategoryFactory;
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
     * @param ResourceCategory $resource
     * @param CategoryFactory $categoryFactory
     * @param CategoryInterfaceFactory $dataCategoryFactory
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param CategorySearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param IdentityMap|null $identityMap
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        ResourceCategory                      $resource,
        CategoryFactory                       $categoryFactory,
        CategoryInterfaceFactory              $dataCategoryFactory,
        CategoryCollectionFactory             $categoryCollectionFactory,
        CategorySearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper                  $dataObjectHelper,
        DataObjectProcessor               $dataObjectProcessor,
        StoreManagerInterface             $storeManager,
        ?IdentityMap                      $identityMap = null,
        CollectionProcessorInterface      $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->categoryFactory = $categoryFactory;
        $this->dataCategoryFactory = $dataCategoryFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
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
    public function save(CategoryInterface $category)
    {
        try {
            $categoryId = $category->getId();
            if ($category->getStoreId() === null) {
                $storeId = $this->storeManager->getStore()->getId();
                $category->setStoreId($storeId);
            }
            //         $this->validateLayoutUpdate($category);
     //       $this->validateRoutesDuplication($category);  //xem trung nhau cua url_rewrite
            $this->resource->save($category);
            $this->identityMap->add($category);
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
        return $category;
    }

    /**
     * Validate new layout update values.
     *
     * @param CategoryInterface $category
     * @return void
     * @throws CouldNotSaveException
     */

    // xet url_rewrite khac nhau
//    private function validateRoutesDuplication($category): void
//    {
//        $collection = $this->categoryCollectionFactory->create()->addFieldToFilter('url_rewrite', ['eq' => $category->getUrlRewrite()]);
//
//        if ($category->getId()) {
//            $collection->addFieldToFilter('id', ['neq' => $category->getId()]);
//        }
//        if (count($collection->getItems())) {
//            throw new CouldNotSaveException(
//                __('The value specified in the UrlRewrite field would generate a URL that already exists.')
//            );
//        }
//    }

    /**
     * Load Movie data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return CategorySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->categoryCollectionFactory->create();

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
     * @param string $categoryId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($categoryId)
    {
        return $this->delete($this->getById($categoryId));
    }

    /**
     * Delete Movie
     *
     * @param CategoryInterface $category
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CategoryInterface $category)
    {
        try {
            $this->resource->delete($category);
            $this->identityMap->remove($category->getId());
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
     * @param string $categoryId
     * @return Category
     * @throws NoSuchEntityException
     */
    public function getById($categoryId)
    {
        $category = $this->categoryFactory->create();
        $category->load($categoryId);
        if (!$category->getId()) {
            throw new NoSuchEntityException(__('The CMS page with the "%1" ID doesn\'t exist.', $categoryId));
        }

        return $category;
    }
}
