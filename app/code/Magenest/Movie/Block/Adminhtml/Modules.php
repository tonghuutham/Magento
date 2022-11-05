<?php

namespace Magenest\Movie\Block\Adminhtml;

use Exception;
use Magento\Backend\Block\Template;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Module\FullModuleList;
use Magento\Sales\Api\CreditmemoRepositoryInterface;
use Magento\Sales\Api\InvoiceRepositoryInterface;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;

class Modules extends Template
{
    protected $fullModuleList;
    protected $customerGroup;
    protected $searchCriteriaBuilder;
    private $_orderFactory;
    private $logger;
    private $invoiceRepository;

    public function __construct(
        FullModuleList                                                 $fullModuleList,
        Template\Context                                               $context,
        CustomerGroup                                                  $customerGroup,
        \Magento\Sales\Model\OrderFactory                              $orderFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Attribute\Source\Status         $productStatus,
        InvoiceRepositoryInterface                                     $invoiceRepository,
        SearchCriteriaBuilder                                          $searchCriteriaBuilder,
        LoggerInterface                                                $logger,
        Visibility                                                     $productVisibility,
        CreditmemoRepositoryInterface                                  $creditmemoRepository,
        array                                                          $data = []
    ) {
        $this->fullModuleList = $fullModuleList;
        $this->_orderFactory = $orderFactory;
        $this->customerGroup = $customerGroup;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        $this->invoiceRepository = $invoiceRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->creditmemoRepository = $creditmemoRepository;

        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    public function modulesList()
    {
        $allModules = $this->fullModuleList->getAll();
        return count($allModules);
    }

    public function getCustomerGroups()
    {
        $customerGroups = $this->customerGroup->toOptionArray();
        return count($customerGroups);
    }

    public function getGrandTotal()
    {
        /** @var Order $order */
        $order = $this->_orderFactory->create()->load($this->getLastOrderId());
        return $order->getGrandTotal();
    }

    public function getProducts()
    {
        /** @var Collection $collection */
        $collection = $this->productCollectionFactory->create();
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        $collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()])
            ->addAttributeToFilter('visibility', ['in' => $this->productVisibility->getVisibleInSiteIds()]);

        return count($collection->getItems());
    }

    public function getCountInvoicesForOrder($orderId)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('order_id', $orderId)->create();
        try {
            $invoices = $this->invoiceRepository->getList($searchCriteria);
            $totalInvoice = $invoices->getTotalCount();
        } catch (Exception $exception) {
            $this->logger->critical($exception->getMessage());
            $totalInvoice = 0;
        }

        return $totalInvoice;
    }
}
