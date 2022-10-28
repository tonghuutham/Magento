<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Block;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Helper\View;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Dashboard Customer Info
 *
 * @api
 * @since 100.0.2
 */
class Account extends Template
{

    /**
     * @var View
     */
    protected $_helperView;
    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;
    /**
     * @var OrderAddressInterface
     */

    private $addressRepository;
    private $customerRepositoryInterface;

    public function __construct(
        Context                                           $context,
        CurrentCustomer                                   $currentCustomer,
        View                                              $helperView,
        OrderAddressInterface                             $address,
        \Magento\Customer\Api\AddressRepositoryInterface  $addressRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        StoreManagerInterface        $storeManager,
        array                                             $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->_helperView = $helperView;
        $this->addressRepository = $addressRepository;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * Get the full name of a customer
     *
     * @return string full name
     */
    public function getName()
    {
        return $this->_helperView->getCustomerName($this->getCustomer());
    }

    /**
     * Returns the Magento Customer Model for this block
     *
     * @return CustomerInterface|null
     */
    public function getCustomer()
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getTelephoneCustomer()
    {
        $customerData = $this->currentCustomer->getCustomer();
        $billingAddressId = $customerData->getDefaultBilling();
        $billingAddress = $this->addressRepository->getById($billingAddressId);
        $telephone = $billingAddress->getTelephone();

        return $telephone;
    }

    public function getAvatarCustomer()
    {
        $customer = $this->customerRepositoryInterface->getById($this->currentCustomer->getCustomerId());
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl . $customer->getCustomAttribute('avatar')->getValue();
    }

    public function execute()
    {
        list($file, $plain) = $this->getFileParams();

        /** @var \Magento\Framework\Filesystem $filesystem */
        $filesystem = $this->_objectManager->get(\Magento\Framework\Filesystem::class);
        $directory = $filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $fileName = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER . '/' . ltrim($file, '/');
        $path = $directory->getAbsolutePath($fileName);
        if (mb_strpos($path, '..') !== false || (!$directory->isFile($fileName)
                && !$this->_objectManager->get(\Magento\MediaStorage\Helper\File\Storage::class)->processStorageFile($path))
        ) {
            throw new NotFoundException(__('Movie not found.'));
        }

        if ($plain) {
            // phpcs:ignore Magento2.Functions.DiscouragedFunction
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

            /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
            $resultRaw = $this->resultRawFactory->create();
            $resultRaw->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Content-type', $contentType, true)
                ->setHeader('Content-Length', $contentLength)
                ->setHeader('Last-Modified', date('r', $contentModify));
            $resultRaw->setContents($directory->readFile($fileName));
            return $resultRaw;
        } else {
            // phpcs:ignore Magento2.Functions.DiscouragedFunction
            $name = pathinfo($path, PATHINFO_BASENAME);
            return $this->_fileFactory->create(
                $name,
                ['type' => 'filename', 'value' => $fileName],
                DirectoryList::MEDIA
            );
        }
    }
}
