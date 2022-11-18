<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magenest\Movie\Model\BlogRepository;

use Magenest\Movie\Api\Data\BlogInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Validate a page repository
 *
 * @api
 */
interface ValidatorInterface
{
    /**
     * Assert the given page valid
     *
     * @param BlogInterface $blog
     * @return void
     * @throws LocalizedException
     */
    public function validate(BlogInterface $blog): void;
}
