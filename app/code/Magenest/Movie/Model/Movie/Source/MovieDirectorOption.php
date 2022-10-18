<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Model\Movie\Source;

use Magenest\Movie\Model\ResourceModel\Director\CollectionFactory as DirectorCollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Model\PageLayout\Config\BuilderInterface;

class MovieDirectorOption implements OptionSourceInterface
{
    /**
     * @var BuilderInterface
     */
    protected $pageLayoutBuilder;
    /**
     * @var array
     * @deprecated 103.0.1 since the cache is now handled by \Magento\Theme\Model\PageLayout\Config\Builder::$configFiles
     */
    protected $options;
    private $directorCollectionFactory;

    /**
     * Constructor
     *
     * @param BuilderInterface $pageLayoutBuilder
     */
    public function __construct(
        BuilderInterface          $pageLayoutBuilder,
        DirectorCollectionFactory $directorCollectionFactory
    ) {
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        $this->directorCollectionFactory = $directorCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $collection = $this->directorCollectionFactory->create();

        $options = [];
        foreach ($collection as $director) {
            $options[] = [
                'label' => $director->getName(),
                'value' => $director->getDirectorId(),
            ];
        }
        return $options;
    }
}
