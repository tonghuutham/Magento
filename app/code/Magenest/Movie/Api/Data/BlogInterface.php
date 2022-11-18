<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Api\Data;

/**
 * Movie actor interface.
 * @api
 * @since 100.0.2
 */
interface BlogInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const AUTHOR_ID = 'author_id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const CONTENT = 'content';
    const URL_REWRITE = 'url_rewrite';
    const STATUS = 'status';
    const CREATE_AT = 'create_at';
    const UPDATE_AT = 'update_at';


    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * getAuthorID
     *
     * @return string
     */
    public function getAuthorId();

    /**
     * Get name
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get name
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get name
     *
     * @return string
     */
    public function getContent();

    /**
     * Get name
     *
     * @return string
     */
    public function getUrlRewrite();

    /**
     * Get name
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get name
     *
     * @return string
     */
    public function getCreateAt();

    /**
     * Get name
     *
     * @return string
     */
    public function getUpdateAt();


    /**
     * Set ID
     *
     * @param int $id
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */


    public function setId($id);

    /**
     * Set author
     *
     * @param string $author_id
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setAuthorId($author_id);

    /**
     * Set title
     *
     * @param string $title
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setTitle($title);

    /**
     * Set description
     *
     * @param string $description
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setDescription($description);

    /**
     * Set content
     *
     * @param string $content
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setContent($content);

    /**
     * Set urlRewrite
     *
     * @param string $url_rewrite
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setUrlRewrite($url_rewrite);

    /**
     * Set status
     *
     * @param string $status
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setStatus($status);

    /**
     * Set createAt
     *
     * @param string $create_at
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setCreateAt($create_at);

    /**
     * Set updateAt
     *
     * @param string $update_at
     * @return \Magenest\Movie\Api\Data\BlogInterface
     */
    public function setUpdateAt($update_at);


}
