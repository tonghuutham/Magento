<?php

namespace Magenest\Movie\Model;

use Magenest\Movie\Api\Data\MovieInterface;
use Magenest\Movie\Api\Data\MovieInterfaceFactory;
use Magenest\Movie\Api\MovieRepositoryInterface;
use Magenest\Movie\Model\ResourceModel\Movie as ResourceMovie;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory as MovieCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Route\Config;
use Magento\Framework\EntityManager\HydratorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;


class MovieRepository implements MovieRepositoryInterface
{

    /**
     * @var ResourceMovie
     */
    protected $resource;

    /**
     * @var MovieFactory
     */
    protected $movieFactory;
    protected $movieActorFactory;

    /**
     * @var MovieCollectionFactory
     */
    protected $movieCollectionFactory;
    protected $movieActorCollectionFactory;

//    /**
//     * @var Data\MovieSearchResultsInterfaceFactory
//     */
//    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var MovieInterfaceFactory
     */
    protected $dataMovieFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var IdentityMap
     */
    private $identityMap;

//    /**
//     * @var HydratorInterface
//     */
//    private $hydrator;

    /**
     * @var Config
     */
    private $routeConfig;

    /**
     * @param ResourceMovie $resource
     * @param MovieFactory $movieFactory
     * @param MovieInterfaceFactory $dataMovieFactory
     * @param MovieCollectionFactory $movieCollectionFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param HydratorInterface|null $hydrator
     * @param Config|null $routeConfig
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        ResourceMovie                $resource,
        MovieFactory                 $movieFactory,
        MovieInterfaceFactory        $dataMovieFactory,
        MovieCollectionFactory       $movieCollectionFactory,
        DataObjectHelper             $dataObjectHelper,
        DataObjectProcessor          $dataObjectProcessor,
        StoreManagerInterface        $storeManager,
        CollectionProcessorInterface $collectionProcessor = null,
        ?HydratorInterface           $hydrator = null,
        ?Config                      $routeConfig = null
    ) {
        $this->resource = $resource;
        $this->movieFactory = $movieFactory;
        $this->movieCollectionFactory = $movieCollectionFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataMovieFactory = $dataMovieFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        // $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
        // $this->identityMap = $identityMap ?? ObjectManager::getInstance()
        //   ->get(IdentityMap::class);
        $this->hydrator = $hydrator ?: ObjectManager::getInstance()
            ->get(HydratorInterface::class);
        $this->routeConfig = $routeConfig ?? ObjectManager::getInstance()
            ->get(Config::class);
    }

    /**
     * @inheritDoc
     */
    public function save(MovieInterface $movie)
    {
        try {
            $movieId = $movie->getId();
            if ($movieId && !($movie instanceof Movie && $movie->getOrigData())) {
                $movie = $this->hydrator->hydrate($this->getById($movieId), $this->hydrator->extract($movie));
            }
            if ($movie->getStoreId() === null) {
                $storeId = $this->storeManager->getStore()->getId();
                $movie->setStoreId($storeId);
            }
            // $this->validateLayoutUpdate($movie);
            // $this->validateRoutesDuplication($movie);
            $this->resource->save($movie);
//          $this->identityMap->add($movie);
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
        return $movie;
    }

    /**
     * Save Movie data
     *
     * @param MovieInterface|Movie $movie
     * @return Movie
     * @throws CouldNotSaveException
     */

    /**
     * @inheritDoc
     */
    public function getById($movieId)
    {
        // TODO: Implement getById() method.
    }

    /**
     * Validate new layout update values.
     *
     * @param MovieInterface $movie
     * @return void
     * @throws InvalidArgumentException
     */
//    private function validateLayoutUpdate(MovieInterface $movie): void
//    {
//        //Persisted data
//        $oldData = null;
//        if ($movie->getId() && $movie instanceof Movie) {
//            $oldData = $movie->getOrigData();
//        }
//        //Custom layout update can be removed or kept as is.
//        if ($movie->getCustomLayoutUpdateXml()
//            && (
//                !$oldData
//                || $movie->getCustomLayoutUpdateXml() !== $oldData[Data\MovieInterface::CUSTOM_LAYOUT_UPDATE_XML]
//            )
//        ) {
//            throw new InvalidArgumentException('Custom layout updates must be selected from a file');
//        }
//        if ($movie->getLayoutUpdateXml()
//            && (!$oldData || $movie->getLayoutUpdateXml() !== $oldData[Data\MovieInterface::LAYOUT_UPDATE_XML])
//        ) {
//            throw new InvalidArgumentException('Custom layout updates must be selected from a file');
//        }
//    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(MovieInterface $movie)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteById($movieId)
    {
        // TODO: Implement deleteById() method.
    }
}
