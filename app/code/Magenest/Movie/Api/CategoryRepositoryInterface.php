<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Api;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * MOVIE movie CRUD interface.
 * @api
 * @since 100.0.2
 */
interface CategoryRepositoryInterface
{
    /**
     * Save movie
     *
     * @param \Magenest\Movie\Api\Data\CategoryInterface $category
     * @return \Magenest\Movie\Api\Data\CategoryInterface
     * @throws LocalizedException
     */
    public function save(\Magenest\Movie\Api\Data\CategoryInterface $category);

    /**
     * Retrieve actor
     *
     * @param int $categoryId
     * @return \Magenest\Movie\Api\Data\CategoryInterface
     * @throws LocalizedException
     */
    public function getById($categoryId);

    /**
     * Retrieve movies matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magenest\Movie\Api\Data\CategorySearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete movie.
     *
     * @param \Magenest\Movie\Api\Data\CategoryInterface $id
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(\Magenest\Movie\Api\Data\CategoryInterface $id);

    /**
     * Delete actor by ID.
     *
     * @param int $categoryId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($categoryId);
}
