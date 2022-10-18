<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Downloadable\Controller\Adminhtml\Downloadable\Product\Edit;

use Magento\Catalog\Controller\Adminhtml\Product\RelatedGrid as CatalogRelatedGrid;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Class RelatedGrid
 *
 * @package Magento\Downloadable\Controller\adminhtml\Downloadable\Product\Edit
 * @deprecated Not used since related products grid moved to UI components.
 * @see Magento_Catalog::view/adminhtml/ui_component/related_product_listing.xml
 */
class RelatedGrid extends CatalogRelatedGrid implements HttpPostActionInterface
{
}
