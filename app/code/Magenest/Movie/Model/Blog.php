<?php

namespace Magenest\Movie\Model;

use Magenest\Movie\Api\Data\BlogInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Blog extends AbstractModel implements BlogInterface
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
        $this->_init('Magenest\Movie\Model\ResourceModel\Blog');
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getAuthorID()
    {
        return $this->getData(self::AUTHOR_ID);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getUrlRewrite()
    {
        return $this->getData(self::URL_REWRITE);
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getCreateAt()
    {
        return $this->getData(self::CREATE_AT);
    }
    /**
     * @inheritDoc
     */
    public function getUpdateAt()
    {
        return $this->getData(self::UPDATE_AT);
    }

    /**
     * Set identifier
     *
     * @param string $author_id
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setAuthorId($author_id)
    {
        return $this->setData(self::AUTHOR_ID, $author_id);

    }

    /**
     * Set identifier
     *
     * @param string $title
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);

    }

    /**
     * Set identifier
     *
     * @param string $description
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Set identifier
     *
     * @param string $content
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);

    }
    /**
     * Set identifier
     *
     * @param string $url_rewrite
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setUrlRewrite($url_rewrite)
    {
        return $this->setData(self::URL_REWRITE, $url_rewrite);

    }
    /**
     * Set identifier
     *
     * @param string $status
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);

    }
    /**
     * Set identifier
     *
     * @param string $create_at
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setCreateAt($create_at)
    {
        return $this->setData(self::CREATE_AT, $create_at);

    }
    /**
     * Set identifier
     *
     * @param string $update_at
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setUpdateAt($update_at)
    {
        return $this->setData(self::UPDATE_AT, $update_at);

    }
}
