<?php

namespace Magenest\Movie\Plugin;


use Magento\Catalog\Model\Product\Configuration\Item\ItemInterface;
use Magento\Catalog\Model\Product\Configuration\Item\ItemResolverComposite;

class ProductShoppingCartPlugin
{

    public function afterGetFinalProduct(ItemResolverComposite $subject, $result, ItemInterface $item)
    {
        $productType = $item->getProductType();
        if ($productType === 'configurable') {
            return current($item->getChildren())->getProduct();
        }
        return $result;
    }
}
