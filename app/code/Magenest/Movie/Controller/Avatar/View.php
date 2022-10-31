<?php

/**
 * Lof
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Lof.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Lof
 * @package     Lof_CustomerAvatar
 * @copyright   Copyright (c) 2019 Lof (https://landofcoder.com/)
 * @license     https://landofcoder.com/LICENSE.txt
 */

namespace Magenest\Movie\Controller\Avatar;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Filesystem;
use Magento\Framework\Url\DecoderInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\MediaStorage\Helper\File\Storage;

/**
 * Class View
 * @package Magenest\Movie\Controller\Avatar
 */
class View extends \Magento\Framework\App\Action\Action
{
    /**
     * @var RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var DecoderInterface
     */
    protected $urlDecoder;

    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param DecoderInterface $urlDecoder
     * @param FileFactory $fileFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        RawFactory                            $resultRawFactory,
        DecoderInterface                      $urlDecoder,
        FileFactory                           $fileFactory
    ) {
        $this->resultRawFactory = $resultRawFactory;
        $this->urlDecoder = $urlDecoder;
        $this->fileFactory = $fileFactory;
        return parent::__construct($context);
    }

    /**
     * View action
     *
     * @return PageFactory
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $file = null;
        $plain = false;
        if ($this->getRequest()->getParam('file')) {
            // download file
            $file = $this->urlDecoder->decode(
                $this->getRequest()->getParam('file')
            );
        } elseif ($this->getRequest()->getParam('image')) {
            // show plain image
            $file = $this->urlDecoder->decode(
                $this->getRequest()->getParam('image')
            );
            $plain = true;
        } else {
            throw new NotFoundException(__('Page not found.'));
        }

        /** @var Filesystem $filesystem */
        $filesystem = $this->_objectManager->get(Filesystem::class);
        $directory = $filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $fileName = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER . '/' . ltrim($file, '/');
        $path = $directory->getAbsolutePath($fileName);

        if (!$directory->isFile($fileName)
            && !$this->_objectManager->get(Storage::class)->processStorageFile($path)
        ) {
            throw new NotFoundException(__('Page not found.'));
        }

        if ($plain) {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            switch (strtolower($extension)) {
                case 'gif':
                    $contentType = 'image/gif';
                    break;
                case 'jpg':
                    $contentType = 'image/jpeg';
                    break;
                case 'png':
                    $contentType = 'image/png';
                    break;
                default:
                    $contentType = 'application/octet-stream';
                    break;
            }
            $stat = $directory->stat($fileName);
            $contentLength = $stat['size'];
            $contentModify = $stat['mtime'];

            /** @var Raw $resultRaw */
            $resultRaw = $this->resultRawFactory->create();
            $resultRaw->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Content-type', $contentType, true)
                ->setHeader('Content-Length', $contentLength)
                ->setHeader('Last-Modified', date('r', $contentModify));
            $resultRaw->setContents($directory->readFile($fileName));
            return $resultRaw;
        } else {
            $name = pathinfo($path, PATHINFO_BASENAME);
            $this->fileFactory->create(
                $name,
                ['type' => 'filename', 'value' => $fileName],
                DirectoryList::MEDIA
            );
        }
    }
}
