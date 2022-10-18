<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magenest\Movie\Api\Data\MovieInterface;
use Magenest\Movie\Api\MovieRepositoryInterface;
use Magenest\Movie\Model\Movie;
use Magenest\Movie\Model\MovieActorFactory;
use Magenest\Movie\Model\MovieFactory;
use Magenest\Movie\Model\ResourceModel\MovieActor as MovieActorResourceModel;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save CMS movie action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magenest_Movie::save';

    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var MovieFactory
     */
    private $movieFactory;

    /**
     * @var MovieRepositoryInterface
     */
    private $movieRepository;
    /**
     * @var MovieActorFactory
     */
    private $movieActorFactory;

    /**
     * @var MovieActorResourceModel
     */
    private $movieActorResourceModel;

    /**
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param MovieActorResourceModel $movieActorResourceModel
     * @param MovieFactory|null $movieFactory
     * @param MovieActorFactory|null $movieActorFactory
     * @param MovieRepositoryInterface|null $movieRepository
     */
    public function __construct(Action\Context $context, PostDataProcessor $dataProcessor, DataPersistorInterface $dataPersistor, MovieActorResourceModel $movieActorResourceModel, MovieFactory $movieFactory = null, MovieActorFactory $movieActorFactory = null, MovieRepositoryInterface $movieRepository = null)
    {
        $this->dataProcessor = $dataProcessor;
        $this->movieActorResourceModel = $movieActorResourceModel;
        $this->dataPersistor = $dataPersistor;
        $this->movieFactory = $movieFactory ?: ObjectManager::getInstance()->get(MovieFactory::class);
        $this->movieActorFactory = $movieActorFactory ?: ObjectManager::getInstance()->get(MovieActorFactory::class);

        $this->movieRepository = $movieRepository ?: ObjectManager::getInstance()->get(MovieRepositoryInterface::class);
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $data = $this->dataProcessor->filter($data);
            if (isset($data['movie_id']) && $data['movie_id'] === 'true') {
//                $data['movie_id'] = Movie::STATUS_ENABLED;
            }
            if (empty($data['movie_id'])) {
                $data['movie_id'] = null;
            }

            /** @var Movie $model */
            $model = $this->movieFactory->create();

            $id = $this->getRequest()->getParam('movie_id');
            if ($id) {
                try {
                    $model = $this->movieRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This movie no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->_eventManager->dispatch('movie_movie_prepare_save', ['movie' => $model, 'request' => $this->getRequest()]);

                $this->movieRepository->save($model);

                foreach ($data['actor_ids'] as $actorId) {
                    $movieActor = $this->movieActorFactory->create();
                    $movieActor->setData(['movie_id' => $model->getMovieId(), 'actor_id' => $actorId]);
                    $this->movieActorResourceModel->save($movieActor);
                }
                $this->messageManager->addSuccessMessage(__('You saved the movie.'));
                return $this->processResultRedirect($model, $resultRedirect, $data);
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the movie.'));
            }

            $this->dataPersistor->set('movie_movie', $data);
            return $resultRedirect->setPath('*/*/edit', ['movie_id' => $this->getRequest()->getParam('movie_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process result redirect
     *
     * @param MovieInterface $model
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     * @throws LocalizedException
     */
    private function processResultRedirect($model, $resultRedirect, $data)
    {
        if ($this->getRequest()->getParam('back', false) === 'duplicate') {
            $newMovie = $this->movieFactory->create(['data' => $data]);
            $newMovie->setId(null);
            $identifier = $model->getIdentifier() . '-' . uniqid();
            $newMovie->setIdentifier($identifier);
            $newMovie->setIsActive(false);
            $this->movieRepository->save($newMovie);
            $this->messageManager->addSuccessMessage(__('You duplicated the movie.'));
            return $resultRedirect->setPath('*/*/edit', ['movie_id' => $newMovie->getId(), '_current' => true]);
        }
        $this->dataPersistor->clear('movie_movie');
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/index', ['movie_id' => $model->getId(), '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
