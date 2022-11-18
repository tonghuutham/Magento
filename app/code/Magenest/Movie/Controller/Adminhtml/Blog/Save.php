<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Controller\Adminhtml\Blog;

use Magenest\Movie\Api\BlogRepositoryInterface;
use Magenest\Movie\Api\Data\BlogInterface;
use Magenest\Movie\Controller\Adminhtml\Movie\PostDataProcessor;
use Magenest\Movie\Model\Blog;
use Magenest\Movie\Model\BlogFactory;
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
     * @var BlogFactory
     */
    private $blogFactory;

    /**
     * @var BlogRepositoryInterface
     */
    private $magenestBlogRepository;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param BlogFactory|null $blogFactory
     * @param BlogRepositoryInterface|null $magenestBlogRepository
     */
    public function __construct(
        Action\Context           $context,
        PostDataProcessor        $dataProcessor,
        DataPersistorInterface   $dataPersistor,
        BlogFactory             $blogFactory = null,
        BlogRepositoryInterface $magenestBlogRepository = null
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->blogFactory = $blogFactory ?: ObjectManager::getInstance()->get(BlogFactory::class);
        $this->magenestBlogRepository = $magenestBlogRepository ?: ObjectManager::getInstance()->get(BlogRepositoryInterface::class);
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
            if (isset($data['id']) && $data['id'] === 'true') {
//                $data['id'] = Actor::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            /** @var Blog $model */
            $model = $this->blogFactory->create();

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->magenestBlogRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This actor no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->_eventManager->dispatch(
                    'movie_blog_prepare_save',
                    ['blog' => $model, 'request' => $this->getRequest()]
                );

                $this->magenestBlogRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the blog.'));
                return $this->processResultRedirect($model, $resultRedirect, $data);
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the blog.'));
            }

            $this->dataPersistor->set('movie_blog', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process result redirect
     *
     * @param BlogInterface $model
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     * @throws LocalizedException
     */
    private function processResultRedirect($model, $resultRedirect, $data)
    {
        if ($this->getRequest()->getParam('back', false) === 'duplicate') {
            $newBlog = $this->blogFactory->create(['data' => $data]);
            $newBlog->setId(null);
            $identifier = $model->getIdentifier() . '-' . uniqid();
            $newBlog->setIdentifier($identifier);
            $newBlog->setIsActive(false);
            $this->magenestBlogRepository->save($newBlog);
            $this->messageManager->addSuccessMessage(__('You duplicated the actor.'));
            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'id' => $newBlog->getId(),
                    '_current' => true,
                ]
            );
        }
        $this->dataPersistor->clear('movie_blog');
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/index', ['id' => $model->getId(), '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
