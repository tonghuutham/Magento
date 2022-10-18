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
interface ActorInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ACTOR_ID = 'actor_id';
    const NAME = 'name';


    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();


    /**
     * Set ID
     *
     * @param int $id
     * @return ActorInterface
     */


    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     * @return ActorInterface
     */
    public function setName($name);


}
