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
 * @category    Magenest
 * @package     Magenest_Movie
 * @copyright   Copyright (c) 2019 Lof (https://landofcoder.com/)
 * @license     https://landofcoder.com/LICENSE.txt
 */

namespace Magenest\Movie\Ui\Component\Listing\Column;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

/**
 * Class Avatar
 * @package Lof\CustomerAvatar\Ui\Component\Listing\Columns
 */
class Avatar extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Magento\Framework\View\Element\AbstractBlock
     */
    protected $movieUrl;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface                         $context,
        UiComponentFactory                       $uiComponentFactory,
        \Magento\Framework\UrlInterface          $urlBuilder,
        \Magento\Framework\View\Asset\Repository $movieUrl,
        array                                    $components = [],
        array                                    $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->movieUrl = $movieUrl;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $customer = new DataObject($item);
                $picture_url = !empty($customer["profile_picture"]) ? $this->urlBuilder->getUrl(
                    'customer/index/movie/image/' . base64_encode($customer["profile_picture"])
                ) : $this->movieUrl->getUrl('Magenest_Movie::images/no-profile-photo.jpg');
                $item[$fieldName . '_src'] = $picture_url;
                $item[$fieldName . '_orig_src'] = $picture_url;
                $item[$fieldName . '_alt'] = 'The profile picture';
            }
        }

        return $dataSource;
    }
}
