<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Model\Category;

use Magenest\Movie\Model\Category;

/**
 * Identity map of loaded pages.
 */
class IdentityMap
{
    /**
     * @var Category[]
     */
    private $blogs = [];

    /**
     * Add a page to the list.
     *
     * @param Category $blog
     * @throws \InvalidArgumentException When page doesn't have an ID.
     * @return void
     */
    public function add(Category $blog): void
    {
        if (!$blog->getId()) {
            throw new \InvalidArgumentException('Cannot add non-persisted page to identity map');
        }
        $this->blogs[$blog->getId()] = $blog;
    }

    /**
     * Find a loaded page by ID.
     *
     * @param int $id
     * @return Category|null
     */
    public function get(int $id): ?Category
    {
        if (array_key_exists($id, $this->blogs)) {
            return $this->blogs[$id];
        }

        return null;
    }

    /**
     * Remove the page from the list.
     *
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        unset($this->blogs[$id]);
    }

    /**
     * Clear the list.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->blogs = [];
    }
}
