<?php

namespace Magenest\Movie\Observer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Element\Context;
use Psr\Log\LoggerInterface;

class CustomerEvent implements ObserverInterface
{
    protected $_request;
    protected $_layout;
    protected $_objectManager = null;
    protected $_customerGroup;
    protected $_customerRepositoryInterface;
    private $logger;

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        Context                     $context,
        ObjectManagerInterface      $objectManager,
        LoggerInterface             $logger,
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->logger = $logger;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

    /**
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        $myEventData = $observer->getData('customer');
        $myEventData->setFirstname('Magenest');
    }
}
