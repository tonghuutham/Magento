<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Reports\Controller\Adminhtml\Report\Shopcart;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Reports\Controller\Adminhtml\Report\Shopcart\Abandoned as ShopCartAbandoned;

/**
 * Class \Magento\Reports\Controller\adminhtml\Report\Shopcart\ExportAbandonedExcel
 */
class ExportAbandonedExcel extends ShopCartAbandoned implements HttpGetActionInterface
{
    /**
     * Export abandoned carts report to Excel XML format
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $fileName = 'shopcart_abandoned.xml';
        $content = $this->_view->getLayout()->createBlock(
            \Magento\Reports\Block\Adminhtml\Shopcart\Abandoned\Grid::class
        )->getExcelFile(
            $fileName
        );

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
