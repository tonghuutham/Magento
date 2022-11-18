<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Model\Blog\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Model\PageLayout\Config\BuilderInterface;
use Magento\User\Model\ResourceModel\User\CollectionFactory as UserCollectionFactory;

class AuthorOption implements OptionSourceInterface
{
    /**
     * @var BuilderInterface
     */
    protected $pageLayoutBuilder;
    /**
     * @var array
     * @deprecated 103.0.1 since the cache is now handled by \Magento\Theme\Model\PageLayout\Config\Builder::$configFiles
     */
    protected $options;
    private $userCollectionFactory;

    /**
     * Constructor
     *
     * @param BuilderInterface $pageLayoutBuilder
     */
    public function __construct(
        BuilderInterface      $pageLayoutBuilder,
        UserCollectionFactory $userCollectionFactory
    ) {
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        $this->userCollectionFactory = $userCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $collection = $this->userCollectionFactory->create();

        $options = [];
        foreach ($collection as $user) {
            $options[] = [
                'label' => $user->getLastName(),
                'value' => $user->getId(),
            ];
        }
        return $options;
    }
}
