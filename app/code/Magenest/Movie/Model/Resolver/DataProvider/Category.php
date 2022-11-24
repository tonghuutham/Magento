<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Model\Resolver\DataProvider;

use Magenest\Movie\Api\CategoryRepositoryInterface;
use Magenest\Movie\Api\Data\CategoryInterface;
use Magenest\Movie\Api\GetCategoryByIdentifierInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Widget\Model\Template\FilterEmulate;

/**
 * Movie Blog data provider
 */
class Category
{
    /**
     * @var GetCategoryByIdentifierInterface
     */
    private $categoryByIdentifier;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var FilterEmulate
     */
    private $widgetFilter;

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     * @param FilterEmulate $widgetFilter
     * @param GetCategoryByIdentifierInterface $getCategoryByIdentifier
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        FilterEmulate $widgetFilter,
        GetCategoryByIdentifierInterface $getCategoryByIdentifier
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->widgetFilter = $widgetFilter;
        $this->categoryByIdentifier = $getCategoryByIdentifier;
    }
    /**
     * Returns blog data by blog_id
     *
     * @param int $categoryId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getDataByCategoryId(int $categoryId): array
    {
        $category = $this->categoryRepository->getById($categoryId);

        return $this->convertBlogData($category);
    }
    /**
     * Convert blog data
     *
     * @param CategoryInterface $category
     * @return array
     * @throws NoSuchEntityException
     */
    private function convertBlogData(CategoryInterface $category)
    {
//        if (false === $category->isActive()) {
//            throw new NoSuchEntityException();
//        }

        $renderedName = $this->widgetFilter->filter($category->getId());
        $categoryData = [
            CategoryInterface::ID => $renderedName,
            CategoryInterface::NAME => $category->getName(),

        ];
        return $categoryData;
    }

    /**
     * Returns blog data by blog identifier
     *
     * @param string $categoryName
     * @param int $storeId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getDataByCategoryName(string $categoryName, int $storeId): array
    {
        $category = $this->categoryByIdentifier->execute($categoryName, $storeId);

        return $this->convertBlogData($category);
    }
}
