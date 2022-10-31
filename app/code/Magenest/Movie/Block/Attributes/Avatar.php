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

namespace Magenest\Movie\Block\Attributes;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Model\Customer;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Element\Template\Context;
use Magento\MediaStorage\Helper\File\Storage;

/**
 * Class Avatar
 * @package Lof\CustomerAvatar\Block\Attributes
 */
class Avatar extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \Magento\Framework\View\Element\AbstractBlock
     */
    protected $movieUrl;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param Repository $movieUrl
     * @param Customer $customer
     */
    public function __construct(
        Context                                  $context,
        ObjectManagerInterface                   $objectManager,
        Repository $movieUrl,
        Customer         $customer
    ) {
        $this->objectManager = $objectManager;
        $this->movieUrl = $movieUrl;
        $this->customer = $customer;
        parent::__construct($context);
    }

    /**
     * Get the avatar of the customer is already logged in
     * @return string
     */
    public function getAvatarCurrentCustomer($file)
    {
        if ($this->checkImageFile(base64_encode($file)) === true) {
            return $this->getUrl('movie/avatar/view/', ['image' => base64_encode($file)]);
        }
        return $this->movieUrl->getUrl('Magenest_Movie::images/no-profile-photo.jpg');
    }

    /**
     * Check the file is already exist in the path.
     * @return boolean
     */
    public function checkImageFile($file)
    {
        $file = base64_decode($file);
        $filesystem = $this->objectManager->get(Filesystem::class);
        $directory = $filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $fileName = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER . '/' . ltrim($file, '/');
        $path = $directory->getAbsolutePath($fileName);
        if (!$directory->isFile($fileName)
            && !$this->objectManager->get(Storage::class)->processStorageFile($path)
        ) {
            return false;
        }
        return true;
    }

    /**
     * Get the avatar of the customer by the customer id
     * @return string
     */
    public function getCustomerAvatarById($customer_id = false)
    {
        if ($customer_id) {
            $customerDetail = $this->customer->load($customer_id);
            if ($customerDetail && !empty($customerDetail->getProfilePicture())) {
                if ($this->checkImageFile(base64_encode($customerDetail->getProfilePicture())) === true) {
                    return $this->getUrl(
                        'movie/avatar/view/',
                        ['image' => base64_encode($customerDetail->getProfilePicture())]
                    );
                }
            }
        }
        return $this->movieUrl->getUrl('Magenest_Movie::images/no-profile-photo.jpg');
    }
}
