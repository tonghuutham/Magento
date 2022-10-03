<?php

namespace Magenest\Movie\Model\ResourceModel\Director;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Movie\Model\Director;
use Magenest\Movie\Model\ResourceModel\Director as DirectorResourceModel;

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
}
