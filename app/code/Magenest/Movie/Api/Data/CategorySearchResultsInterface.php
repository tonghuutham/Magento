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
interface CategorySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get blog list.
     *
     * @return \Magenest\Movie\Api\Data\CategoryInterface[]
     */
    public function getItems();

    /**
     * Set blog list.
     *
     * @param \Magenest\Movie\Api\Data\CategoryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
