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
interface BlogRepositoryInterface
{
    /**
     * Save movie
     *
     * @param \Magenest\Movie\Api\Data\BlogInterface $blog
     * @return \Magenest\Movie\Api\Data\BlogInterface
     * @throws LocalizedException
     */
    public function save(\Magenest\Movie\Api\Data\BlogInterface $blog);

    /**
     * Retrieve actor
     *
     * @param int $blogId
     * @return \Magenest\Movie\Api\Data\BlogInterface
     * @throws LocalizedException
     */
    public function getById($blogId);

    /**
     * Retrieve movies matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magenest\Movie\Api\Data\BlogSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete movie.
     *
     * @param \Magenest\Movie\Api\Data\BlogInterface $id
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(\Magenest\Movie\Api\Data\BlogInterface $id);

    /**
     * Delete actor by ID.
     *
     * @param int $blogId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($blogId);
}
