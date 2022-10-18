<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Api;

use Magenest\Movie\Api\Data\MovieInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Command to load the page data by specified identifier
 * @api
 * @since 103.0.0
 */
interface GetMovieByIdentifierInterface
{
    /**
     * Load page data by given page identifier.
     *
     * @param string $identifier
     * @param int $storeId
     * @return MovieInterface
     * @throws NoSuchEntityException
     * @since 103.0.0
     */
    public function execute(string $identifier, int $storeId): MovieInterface;
}
