<?php

namespace Packt\HelloWorld\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Subscription extends AbstractDb
{
    public function _construct()
    {
        $this->_init('packt_helloworld_subscription', 'subscription_id');
    }
}
