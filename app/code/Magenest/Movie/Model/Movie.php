<?php

namespace Magenest\Movie\Model;
use Magenest\Movie\Api\Data\MovieInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Movie extends AbstractModel implements MovieInterface
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
        $this->_init('Magenest\Movie\Model\ResourceModel\Movie');
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    /**
     * @inheritDoc
     */
    public function getRating()
    {
        // TODO: Implement getRating() method.
    }

    /**
     * @inheritDoc
     */
    public function getDirectorId()
    {
        // TODO: Implement getDirectorId() method.
    }




    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);

    }

    /**
     * @inheritDoc
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);

    }

    /**
     * @inheritDoc
     */
    public function setRating($rating)
    {
        return $this->setData(self::RATING, $rating);
    }

    /**
     * @inheritDoc
     */
    public function setDirectorId($director_id)
    {
        return $this->setData(self::DIRECTOR_ID, $director_id);

    }
}
