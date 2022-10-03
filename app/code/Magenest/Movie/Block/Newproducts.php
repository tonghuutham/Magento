<?php

namespace Packt\HelloWorld\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;

class Newproducts extends Template
{

    private $_productCollectionFactory;

    public function __construct(Template\Context $context, CollectionFactory $productCollectionFactory, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_productCollectionFactory = $productCollectionFactory;
    }

    public function getProducts()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*')->setOrder('created_at')->setPageSize(5);
        return $collection;
    }

}
