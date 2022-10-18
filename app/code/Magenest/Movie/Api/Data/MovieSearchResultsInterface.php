<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms page search results.
 * @api
 * @since 100.0.2
 */
interface MovieSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return MovieInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param MovieInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
