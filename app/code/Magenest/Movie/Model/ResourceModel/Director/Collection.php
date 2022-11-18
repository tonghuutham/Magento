<?php

namespace Magenest\Movie\Model\ResourceModel\Director;

use Magenest\Movie\Model\Director;
use Magenest\Movie\Model\ResourceModel\Director as DirectorResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Director Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(Director::class, DirectorResourceModel::class);
    }
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->join(
            ['mm' => $this->getTable('magenest_movie')],
            'mm.director_id=main_table.director_id',
            [
                'movie_id',
                'movie_name' => 'mm.name',
                'rating',
                'description'
            ]
        );
    }
}
