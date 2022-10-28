<?php

namespace Magenest\Movie\Plugin;

use Magento\Checkout\CustomerData\AbstractItem;
use Magento\Quote\Model\Quote\Item;

class ProductMiniCartPlugin
{
    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $image;

    public function __construct(
        \Magento\Catalog\Helper\Image $image
    ) {
        $this->image = $image;
    }

    public function afterGetItemData(AbstractItem $subject, $result, Item $item)
    {
        $productType = $item->getProductType();
        if ($productType === 'configurable') {
            $product = current($item->getChildren())->getProduct();
            $imageUrl = $this->image->init($product, 'product_page_image_small')
                ->setImageFile($product->getSmallImage()) // image,small_image,thumbnail
                ->resize(380)
                ->getUrl();
            $result['product_image']['src'] = $imageUrl;
            $result['product_name'] = $product->getName();
        }



        return $result;
    }
}
