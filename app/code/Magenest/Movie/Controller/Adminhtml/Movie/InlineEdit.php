<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Exception;
use Magenest\Movie\Api\Data\MovieInterface;
use Magenest\Movie\Api\MovieRepositoryInterface as MovieRepository;
use Magento\Backend\App\Action\Context;
use Magenest\Movie\Model\Movie;
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
     * @var \Magenest\Movie\Api\MovieRepositoryInterface
     */
    protected $movieRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param MovieRepository $movieRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context           $context,
        PostDataProcessor $dataProcessor,
        MovieRepository   $movieRepository,
        JsonFactory       $jsonFactory
    ) {
        parent::__construct($context);
        $this->dataProcessor = $dataProcessor;
        $this->movieRepository = $movieRepository;
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

        foreach (array_keys($postItems) as $movieId) {
            /** @var \Magenest\Movie\Model\Movie $movie */
            $movie = $this->movieRepository->getById($movieId);
            try {
                $extendedMovieData = $movie->getData();
                $movieData = $this->filterPostWithDateConverting($postItems[$movieId], $extendedMovieData);
                $this->validatePost($movieData, $movie, $error, $messages);
                $this->setCmsMovieData($movie, $extendedMovieData, $movieData);
                $this->movieRepository->save($movie);
            } catch (LocalizedException $e) {
                $messages[] = $this->getErrorWithMovieId($movie, $e->getMessage());
                $error = true;
            } catch (RuntimeException $e) {
                $messages[] = $this->getErrorWithMovieId($movie, $e->getMessage());
                $error = true;
            } catch (Exception $e) {
                $messages[] = $this->getErrorWithMovieId(
                    $movie,
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
     * @param array $movieData
     * @return array
     */
    private function filterPostWithDateConverting($postData = [], $movieData = [])
    {
        $newMovieData = $this->filterPost($postData);
        if (
            !empty($newMovieData['custom_theme_from'])
            && date("Y-m-d", strtotime($postData['custom_theme_from']))
            === date("Y-m-d", strtotime($movieData['custom_theme_from']))
        ) {
            $newMovieData['custom_theme_from'] = date("Y-m-d", strtotime($postData['custom_theme_from']));
        }
        if (
            !empty($newMovieData['custom_theme_to'])
            && date("Y-m-d", strtotime($postData['custom_theme_to']))
            === date("Y-m-d", strtotime($movieData['custom_theme_to']))
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
        $movieData = $this->dataProcessor->filter($postData);
        $movieData['custom_theme'] = isset($movieData['custom_theme']) ? $movieData['custom_theme'] : null;
        $movieData['custom_root_template'] = isset($movieData['custom_root_template'])
            ? $movieData['custom_root_template']
            : null;
        return $movieData;
    }

    /**
     * Validate post data
     *
     * @param array $movieData
     * @param \Magenest\Movie\Model\Movie $movie
     * @param bool $error
     * @param array $messages
     * @return void
     */
    protected function validatePost(array $movieData, Movie $movie, &$error, array &$messages)
    {
        if (!$this->dataProcessor->validateRequireEntry($movieData)) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithMovieId($movie, $error->getText());
            }
        }
    }

    /**
     * Add movie title to error message
     *
     * @param MovieInterface $movie
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithMovieId(MovieInterface $movie, $errorText)
    {
        return '[Movie ID: ' . $movie->getId() . '] ' . $errorText;
    }

    /**
     * Set cms movie data
     *
     * @param \Magenest\Movie\Model\Movie $movie
     * @param array $extendedMovieData
     * @param array $movieData
     * @return $this
     */
    public function setCmsMovieData(Movie $movie, array $extendedMovieData, array $movieData)
    {
        $movie->setData(array_merge($movie->getData(), $extendedMovieData, $movieData));
        return $this;
    }
}
