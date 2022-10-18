<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magenest\Movie\Api\ActorRepositoryInterface;
use Magenest\Movie\Api\Data\ActorInterface;
use Magenest\Movie\Model\Actor;
use Magenest\Movie\Model\ActorFactory;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save CMS actor action.
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
     * @var ActorFactory
     */
    private $actorFactory;

    /**
     * @var ActorRepositoryInterface
     */
    private $actorRepository;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param ActorFactory|null $actorFactory
     * @param ActorRepositoryInterface|null $actorRepository
     */
    public function __construct(
        Action\Context           $context,
        PostDataProcessor        $dataProcessor,
        DataPersistorInterface   $dataPersistor,
        ActorFactory             $actorFactory = null,
        ActorRepositoryInterface $actorRepository = null
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->actorFactory = $actorFactory ?: ObjectManager::getInstance()->get(ActorFactory::class);
        $this->actorRepository = $actorRepository ?: ObjectManager::getInstance()->get(ActorRepositoryInterface::class);
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
            if (isset($data['actor_id']) && $data['actor_id'] === 'true') {
//                $data['actor_id'] = Actor::STATUS_ENABLED;
            }
            if (empty($data['actor_id'])) {
                $data['actor_id'] = null;
            }

            /** @var Actor $model */
            $model = $this->actorFactory->create();

            $id = $this->getRequest()->getParam('actor_id');
            if ($id) {
                try {
                    $model = $this->actorRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This actor no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->_eventManager->dispatch(
                    'movie_actor_prepare_save',
                    ['actor' => $model, 'request' => $this->getRequest()]
                );

                $this->actorRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the actor.'));
                return $this->processResultRedirect($model, $resultRedirect, $data);
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the actor.'));
            }

            $this->dataPersistor->set('movie_actor', $data);
            return $resultRedirect->setPath('*/*/edit', ['actor_id' => $this->getRequest()->getParam('actor_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process result redirect
     *
     * @param ActorInterface $model
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     * @throws LocalizedException
     */
    private function processResultRedirect($model, $resultRedirect, $data)
    {
        if ($this->getRequest()->getParam('back', false) === 'duplicate') {
            $newActor = $this->actorFactory->create(['data' => $data]);
            $newActor->setId(null);
            $identifier = $model->getIdentifier() . '-' . uniqid();
            $newActor->setIdentifier($identifier);
            $newActor->setIsActive(false);
            $this->actorRepository->save($newActor);
            $this->messageManager->addSuccessMessage(__('You duplicated the actor.'));
            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'actor_id' => $newActor->getId(),
                    '_current' => true,
                ]
            );
        }
        $this->dataPersistor->clear('movie_actor');
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/index', ['actor_id' => $model->getId(), '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
