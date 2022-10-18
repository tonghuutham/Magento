<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Model\Movie\Source;

use Magenest\Movie\Model\ResourceModel\Actor\CollectionFactory as ActorCollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Model\PageLayout\Config\BuilderInterface;

class MovieActorNameOption implements OptionSourceInterface
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
    private $actorCollectionFactory;

    /**
     * Constructor
     *
     * @param BuilderInterface $pageLayoutBuilder
     */
    public function __construct(
        BuilderInterface          $pageLayoutBuilder,
        ActorCollectionFactory $actorCollectionFactory
    ) {
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        $this->actorCollectionFactory = $actorCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $collection = $this->actorCollectionFactory->create();

        $options = [];
        foreach ($collection as $actor) {
            $options[] = [
                'label' => $actor->getName(),
                'value' => $actor->getActorId(),
            ];
        }
        return $options;
    }
}
