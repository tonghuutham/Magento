<?php

namespace Magenest\Movie\Block\Adminhtml;

use Magenest\Movie\Model\ResourceModel\Actor\CollectionFactory as ActorCollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

class CountActor extends Field
{
    private $actorCollectionFactory;

    public function __construct(
        ActorCollectionFactory $actorCollectionFactory,
        Context                $context,
        array                  $data = [],
        ?SecureHtmlRenderer    $secureRenderer = null
    ) {
        parent::__construct($context, $data, $secureRenderer);
        $this->actorCollectionFactory = $actorCollectionFactory;
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $collection = $this->actorCollectionFactory->create();

        $countActor = $collection->count();
        return $countActor;
    }
}
