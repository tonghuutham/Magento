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
interface CategoryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const NAME = 'name';


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
    public function getName();




    /**
     * Set ID
     *
     * @param int $id
     * @return \Magenest\Movie\Api\Data\CategoryInterface
     */


    public function setId($id);

    /**
     * Set author
     *
     * @param string $name
     * @return \Magenest\Movie\Api\Data\CategoryInterface
     */
    public function setName($name);


}
