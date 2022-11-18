<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Controller\Adminhtml\Blog;

use Exception;
use Magenest\Movie\Api\Data\BlogInterface;
use Magenest\Movie\Api\BlogRepositoryInterface as MagenestBlogRepository;
use Magento\Backend\App\Action\Context;
use Magenest\Movie\Model\Blog;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use RuntimeException;

/**
 * Cms movie grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Magenest_Movie::save';

    /**
     * @var \Magenest\Movie\Controller\Adminhtml\Movie\PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var \Magenest\Movie\Api\BlogRepositoryInterface
     */
    protected $magenestBlogRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param MagenestBlogRepository $magenestBlogRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context           $context,
        PostDataProcessor $dataProcessor,
        MagenestBlogRepository   $magenestBlogRepository,
        JsonFactory       $jsonFactory
    ) {
        parent::__construct($context);
        $this->dataProcessor = $dataProcessor;
        $this->magenestBlogRepository = $magenestBlogRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Process the request
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData(
                [
                    'messages' => [__('Please correct the data sent.')],
                    'error' => true,
                ]
            );
        }

        foreach (array_keys($postItems) as $blogId) {
            /** @var \Magenest\Movie\Model\Blog $blog */
            $blog = $this->magenestBlogRepository->getById($blogId);
            try {
                $extendedMovieData = $blog->getData();
                $blogData = $this->filterPostWithDateConverting($postItems[$blogId], $extendedMovieData);
                $this->validatePost($blogData, $blog, $error, $messages);
                $this->setCmsMovieData($blog, $extendedMovieData, $blogData);
                $this->magenestBlogRepository->save($blog);
            } catch (LocalizedException $e) {
                $messages[] = $this->getErrorWithMovieId($blog, $e->getMessage());
                $error = true;
            } catch (RuntimeException $e) {
                $messages[] = $this->getErrorWithMovieId($blog, $e->getMessage());
                $error = true;
            } catch (Exception $e) {
                $messages[] = $this->getErrorWithMovieId(
                    $blog,
                    __('Something went wrong while saving the movie.')
                );
                $error = true;
            }
        }

        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error
            ]
        );
    }

    /**
     * Filtering posted data with converting custom theme dates to proper format
     *
     * @param array $postData
     * @param array $blogData
     * @return array
     */
    private function filterPostWithDateConverting($postData = [], $blogData = [])
    {
        $newMovieData = $this->filterPost($postData);
        if (
            !empty($newMovieData['custom_theme_from'])
            && date("Y-m-d", strtotime($postData['custom_theme_from']))
            === date("Y-m-d", strtotime($blogData['custom_theme_from']))
        ) {
            $newMovieData['custom_theme_from'] = date("Y-m-d", strtotime($postData['custom_theme_from']));
        }
        if (
            !empty($newMovieData['custom_theme_to'])
            && date("Y-m-d", strtotime($postData['custom_theme_to']))
            === date("Y-m-d", strtotime($blogData['custom_theme_to']))
        ) {
            $newMovieData['custom_theme_to'] = date("Y-m-d", strtotime($postData['custom_theme_to']));
        }

        return $newMovieData;
    }

    /**
     * Filtering posted data.
     *
     * @param array $postData
     * @return array
     */
    protected function filterPost($postData = [])
    {
        $blogData = $this->dataProcessor->filter($postData);
        $blogData['custom_theme'] = isset($blogData['custom_theme']) ? $blogData['custom_theme'] : null;
        $blogData['custom_root_template'] = isset($blogData['custom_root_template'])
            ? $blogData['custom_root_template']
            : null;
        return $blogData;
    }

    /**
     * Validate post data
     *
     * @param array $blogData
     * @param \Magenest\Movie\Model\Blog $blog
     * @param bool $error
     * @param array $messages
     * @return void
     */
    protected function validatePost(array $blogData, Blog $blog, &$error, array &$messages)
    {
        if (!$this->dataProcessor->validateRequireEntry($blogData)) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithMovieId($blog, $error->getText());
            }
        }
    }

    /**
     * Add movie title to error message
     *
     * @param BlogInterface $blog
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithMovieId(BlogInterface $blog, $errorText)
    {
        return '[Movie ID: ' . $blog->getId() . '] ' . $errorText;
    }

    /**
     * Set cms movie data
     *
     * @param \Magenest\Movie\Model\Movie $blog
     * @param array $extendedMovieData
     * @param array $blogData
     * @return $this
     */
    public function setCmsMovieData(Blog $blog, array $extendedMovieData, array $blogData)
    {
        $blog->setData(array_merge($blog->getData(), $extendedMovieData, $blogData));
        return $this;
    }
}
