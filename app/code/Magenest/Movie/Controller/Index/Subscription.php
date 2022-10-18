<?php

namespace Magenest\Movie\Controller\Index;

use Magento\Framework\App\Action\Action;

class Subscription extends Action
{
    public function execute()
    {
        $subscription = $this->_objectManager->create('Magenest\Movie\Model\Subscription');

        $subscription->setName('Director_A');
        $subscription->save();
        $this->getResponse()->setBody('success');

    }

}

