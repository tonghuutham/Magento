<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Model;

use Magenest\Movie\Api\Data\BlogSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Movie search results.
 */
class BlogSearchResults extends SearchResults implements BlogSearchResultsInterface
{
}
