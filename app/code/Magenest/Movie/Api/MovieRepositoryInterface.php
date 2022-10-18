<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Api;

use Magenest\Movie\Api\Data\MovieInterface;
use Magenest\Movie\Api\Data\MovieSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * MOVIE movie CRUD interface.
 * @api
 * @since 100.0.2
 */
interface MovieRepositoryInterface
{
    /**
     * Save movie
     *
     * @param MovieInterface $movie
     * @return MovieInterface
     * @throws LocalizedException
     */
    public function save(MovieInterface $movie);

    /**
     * Retrieve movie.
     *
     * @param int $movieId
     * @return MovieInterface
     * @throws LocalizedException
     */
    public function getById($movieId);

    /**
     * Retrieve movies matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return MovieSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete movie.
     *
     * @param MovieInterface $movie
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(MovieInterface $movie);

    /**
     * Delete movie by ID.
     *
     * @param int $movieId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($movieId);
}
