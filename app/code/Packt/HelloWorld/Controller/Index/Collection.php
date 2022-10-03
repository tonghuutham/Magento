<?php

namespace Packt\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;


class Collection extends Action
{
    public function execute()
    {
        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')->setPageSize(10, 1);
        $output = '';
        foreach ($productCollection as $product) {
            $output .= $product->getName();
        }
        $this->getResponse()->setBody($output);
    }
}
