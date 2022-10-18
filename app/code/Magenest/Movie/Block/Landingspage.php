<?php
namespace Magenest\Movie\Block;
use Magento\Framework\View\Element\Template;
class Landingspage extends Template
{
    public function getLandingsUrl()
    {
        return $this->getUrl('movie');
    }

    public function getRedirectUrl()
    {
        return $this->getUrl('movie/index/redirect');
    }
}
