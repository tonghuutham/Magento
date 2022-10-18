<?php

namespace Magenest\Movie\Block\Adminhtml;

use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory as MovieCollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

class CountMovie extends Field
{
    private $movieCollectionFactory;

    public function __construct(
        MovieCollectionFactory $movieCollectionFactory,
        Context                $context,
        array                  $data = [],
        ?SecureHtmlRenderer    $secureRenderer = null
    ) {
        parent::__construct($context, $data, $secureRenderer);
        $this->movieCollectionFactory = $movieCollectionFactory;
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $collection = $this->movieCollectionFactory->create();

        $countMovie = $collection->count();
        return $countMovie;
    }
}
