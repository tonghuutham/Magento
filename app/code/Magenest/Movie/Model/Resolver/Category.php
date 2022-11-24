<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Model\Resolver;

use Magenest\Movie\Model\Resolver\DataProvider\Category as CategoryDataProvider;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * MOVIE Blog field resolver, used for GraphQL request processing
 */
class Category implements ResolverInterface
{
    /**
     * @var CategoryDataProvider
     */
    private $categoryDataProvider;

    /**
     *
     * @param CategoryDataProvider $categoryDataProvider
     */
    public function __construct(
        CategoryDataProvider $categoryDataProvider
    ) {
        $this->categoryDataProvider = $categoryDataProvider;
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
        if (!isset($args['id']) && !isset($args['name'])) {
            throw new GraphQlInputException(__('"Movie id/name should be specified'));
        }

        $categoryData = [];

        try {
            if (isset($args['id'])) {
                $categoryData = $this->categoryDataProvider->getDataByCategoryId((int)$args['id']);
            } elseif (isset($args['name'])) {
                $categoryData = $this->categoryDataProvider->getDataByCategoryName(
                    (string)$args['name'],
                    (int)$context->getExtensionAttributes()->getStore()->getId()
                );
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $categoryData;
    }
}
