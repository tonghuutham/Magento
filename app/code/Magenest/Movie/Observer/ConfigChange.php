<?php

namespace Magenest\Movie\Observer;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class ConfigChange implements ObserverInterface
{
    const XML_PATH_FAQ_URL = 'section_id/group_id/field_id1';

    /**
     * @var RequestInterface
     */
    private $request;
    private WriterInterface $configWriter;

    /**
     * ConfigChange constructor.
     * @param RequestInterface $request
     * @param WriterInterface $configWriter
     */
    public function __construct(
        RequestInterface $request,
        WriterInterface  $configWriter
    ) {
        $this->request = $request;
        $this->configWriter = $configWriter;
    }

    public function execute(EventObserver $observer)
    {
        $faqParams = $this->request->getParam('groups');
        $urlKey = $faqParams['group_id']['fields']['field_id1']['value'];
        $this->configWriter->save('section_id/group_id/field_id1', 'Pong');


        return $this;
    }
}
