<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Model;

use Magenest\Movie\Api\Data\CategoryInterface;
use Magenest\Movie\Api\GetCategoryByIdentifierInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GetPageByIdentifier
 */
class GetCategoryByIdentifier implements GetCategoryByIdentifierInterface
{
    /**
     * @var \Magenest\Movie\Model\CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var ResourceModel\Category
     */
    private $categoryResource;

    /**
     * @param CategoryFactory $categoryFactory
     * @param ResourceModel\Category $categoryResource
     */
    public function __construct(
        \Magenest\Movie\Model\CategoryFactory $categoryFactory,
        \Magenest\Movie\Model\ResourceModel\Category $categoryResource
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->categoryResource = $categoryResource;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $identifier, int $storeId) : CategoryInterface
    {
        $category = $this->categoryFactory->create();
        $category->setStoreId($storeId);
        $this->categoryResource->load($category, $identifier, CategoryInterface::ID);

        if (!$category->getId()) {
            throw new NoSuchEntityException(__('The CMS page with the "%1" ID doesn\'t exist.', $identifier));
        }

        return $category;
    }
}
