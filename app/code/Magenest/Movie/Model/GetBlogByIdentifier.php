<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Model;

use Magenest\Movie\Api\Data\BlogInterface;
use Magenest\Movie\Api\GetBlogByIdentifierInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GetPageByIdentifier
 */
class GetBlogByIdentifier implements GetBlogByIdentifierInterface
{
    /**
     * @var \Magenest\Movie\Model\BlogFactory
     */
    private $blogFactory;

    /**
     * @var ResourceModel\Blog
     */
    private $blogResource;

    /**
     * @param BlogFactory $blogFactory
     * @param ResourceModel\Blog $blogResource
     */
    public function __construct(
        \Magenest\Movie\Model\BlogFactory $blogFactory,
        \Magenest\Movie\Model\ResourceModel\Blog $blogResource
    ) {
        $this->blogFactory = $blogFactory;
        $this->blogResource = $blogResource;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $identifier, int $storeId) : BlogInterface
    {
        $blog = $this->blogFactory->create();
        $blog->setStoreId($storeId);
        $this->blogResource->load($blog, $identifier, BlogInterface::ID);

        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('The CMS page with the "%1" ID doesn\'t exist.', $identifier));
        }

        return $blog;
    }
}
