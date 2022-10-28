<?php
namespace Magenest\Movie\Controller\Account;
class Redirect extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $this->_redirect('movie');
    }
}
