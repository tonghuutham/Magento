<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Api\Data;

/**
 * Movie movie interface.
 * @api
 * @since 100.0.2
 */
interface MovieInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const MOVIE_ID = 'movie_id';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const RATING = 'rating';
    const DIRECTOR_ID = 'director_id';


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
     * Get description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get rating
     *
     * @return string|null
     */
    public function getRating();

    /**
     * Get director_id
     *
     * @return string|null
     */
    public function getDirectorId();

    /**
     * Set ID
     *
     * @param int $id
     * @return MovieInterface
     */


    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     * @return MovieInterface
     */
    public function setName($name);

    /**
     * Set decription
     *
     * @param string $description
     * @return MovieInterface
     */
    public function setDescription($description);

    /**
     * Set reting
     *
     * @param string $rating
     * @return MovieInterface
     */
    public function setRating($rating);

    /**
     * Set meta title
     *
     * @param string $director_id
     * @return MovieInterface
     */
    public function setDirectorId($director_id);

}
