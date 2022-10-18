<?php
namespace Magenest\Movie\Controller\Index;
class Redirect extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $this->_redirect('movie');
    }
}
