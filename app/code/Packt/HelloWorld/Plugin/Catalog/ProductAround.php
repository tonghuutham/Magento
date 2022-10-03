<?php
namespace Packt\HelloWorld\Plugin\Catalog;

use Magento\Catalog\Model\Product;
class ProductAround
{
    public function aroundGetName($interceptedInput)
    {
        return $interceptedInput;
    }
}
