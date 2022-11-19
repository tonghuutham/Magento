<?php

namespace Magenest\Movie\Model;

use Magenest\Movie\Api\Data\CategoryInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Category extends AbstractModel implements CategoryInterface
{

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';


    //$_eventPrefix

    /**
     * Model event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'movie';


    public function __construct(Context $context, Registry $registry, AbstractResource $resource = null, AbstractDb $resourceCollection = null, array $data = [])
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('Magenest\Movie\Model\ResourceModel\Category');
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }



    /**
     * Set identifier
     *
     * @param string $name
     * @return \Magenest\Movie\Api\Data\CategoryInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);

    }


}
