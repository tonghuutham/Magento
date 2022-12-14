<?php

namespace Magenest\Movie\Block;

use Magenest\Movie\Model\ResourceModel\Actor\CollectionFactory as ActorCollectionFactory;
use Magenest\Movie\Model\ResourceModel\Director\CollectionFactory as DirectorCollectionFactory;
use Magenest\Movie\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Element\Template;

class Newproducts extends Template
{
    private $_productCollectionFactory;
    private $directorCollectionFactory;
    private $actorCollectionFactory;
    private $blogCollectionFactory;

    /**
     * @var ResourceConnection
     */

    private $resourceConnection;

    public function __construct(
        Template\Context              $context,
        CollectionFactory             $productCollectionFactory,
        DirectorCollectionFactory     $directorCollectionFactory,
        ActorCollectionFactory        $actorCollectionFactory,
        BlogCollectionFactory $blogCollectionFactory,
        ResourceConnection            $resourceConnection,
        array                         $data = []
    ) {
        parent::__construct($context, $data);
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->directorCollectionFactory = $directorCollectionFactory;
        $this->actorCollectionFactory = $actorCollectionFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;

        $this->resourceConnection = $resourceConnection;
    }

    public function getProducts()
    {
        $collection = $this->directorCollectionFactory->create();
        return $collection;
    }

    public function getAuthor()
    {
        $collection = $this->blogCollectionFactory->create();
        return $collection;
    }

    public function getNameActor($movieId)
    {
        $nameActor = $this->actorCollectionFactory->create()->join(
            ['mma' => $this->resourceConnection->getTableName('magenest_movie_actor')],
            'mma.actor_id=main_table.actor_id',
            [
                'actor_name' => 'main_table.name',
            ]
        );

        $actorName = [];
        foreach ($nameActor->getData() as $item) {
            $actorName[] = $item['actor_name'];
        }
        $str = implode(", ", $actorName);

        return $str;
    }
}
