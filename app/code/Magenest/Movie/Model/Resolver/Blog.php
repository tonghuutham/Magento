<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Model\Resolver;

use Magenest\Movie\Model\Resolver\DataProvider\Blog as BlogDataProvider;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * MOVIE Blog field resolver, used for GraphQL request processing
 */
class Blog implements ResolverInterface
{
    /**
     * @var BlogDataProvider
     */
    private $blogDataProvider;

    /**
     *
     * @param BlogDataProvider $blogDataProvider
     */
    public function __construct(
        BlogDataProvider $blogDataProvider
    ) {
        $this->blogDataProvider = $blogDataProvider;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($args['id']) && !isset($args['author_id'])) {
            throw new GraphQlInputException(__('"Movie id/author_id should be specified'));
        }

        $blogData = [];

        try {
            if (isset($args['id'])) {
                $blogData = $this->blogDataProvider->getDataByBlogId((int)$args['id']);
            } elseif (isset($args['author_id'])) {
                $blogData = $this->blogDataProvider->getDataByBlogAuthorId(
                    (string)$args['author_id'],
                    (int)$context->getExtensionAttributes()->getStore()->getId()
                );
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $blogData;
    }
}
