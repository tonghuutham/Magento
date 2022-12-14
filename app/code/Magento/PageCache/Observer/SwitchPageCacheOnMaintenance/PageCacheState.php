<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\PageCache\Observer\SwitchPageCacheOnMaintenance;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class PageCacheState
 *
 * Movie Cache State Observer
 *
 * @deprecated 100.4.0 Originally used by now removed observer SwitchPageCacheOnMaintenance
 */
class PageCacheState
{
    /**
     * Full Movie Cache Off state file name.
     */
    private const PAGE_CACHE_STATE_FILENAME = '.maintenance.fpc.state';

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    private $flagDir;

    /**
     * @param Filesystem $fileSystem
     */
    public function __construct(Filesystem $fileSystem)
    {
        $this->flagDir = $fileSystem->getDirectoryWrite(DirectoryList::VAR_DIR);
    }

    /**
     * Saves Full Movie Cache state.
     *
     * Saves FPC state across requests.
     *
     * @param bool $state
     * @return void
     */
    public function save(bool $state): void
    {
        $this->flagDir->writeFile(self::PAGE_CACHE_STATE_FILENAME, (string)$state);
    }

    /**
     * Returns stored Full Movie Cache state.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        if (!$this->flagDir->isExist(self::PAGE_CACHE_STATE_FILENAME)) {
            return false;
        }

        return (bool)$this->flagDir->readFile(self::PAGE_CACHE_STATE_FILENAME);
    }

    /**
     * Flushes Movie Cache state storage.
     *
     * @return void
     */
    public function flush(): void
    {
        $this->flagDir->delete(self::PAGE_CACHE_STATE_FILENAME);
    }
}
