<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Api;

use Magenest\Movie\Api\Data\ActorInterface;
use Magenest\Movie\Api\Data\ActorSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * ACTOR actor CRUD interface.
 * @api
 * @since 100.0.2
 */
interface ActorRepositoryInterface
{
    /**
     * Save actor
     *
     * @param ActorInterface $actor
     * @return ActorInterface
     * @throws LocalizedException
     */
    public function save(ActorInterface $actor);

    /**
     * Retrieve actor.
     *
     * @param int $actorId
     * @return ActorInterface
     * @throws LocalizedException
     */
    public function getById($actorId);

    /**
     * Retrieve actors matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ActorSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete actor.
     *
     * @param ActorInterface $actor
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(ActorInterface $actor);

    /**
     * Delete actor by ID.
     *
     * @param int $actorId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($actorId);
}
