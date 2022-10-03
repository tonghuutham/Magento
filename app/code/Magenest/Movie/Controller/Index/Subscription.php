<?php

namespace Packt\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;

class Subscription extends Action
{
    public function execute()
    {
        $subscription = $this->_objectManager->create('Packt\HelloWorld\Model\Subscription');

        $subscription->setFirstname('John');
        $subscription->setLastname('Doe');
        $subscription->setEmail('john.doe@example.com');
        $subscription->setMessage('A short message to test');
        $subscription->save();
        $this->getResponse()->setBody('success');

    }

}

