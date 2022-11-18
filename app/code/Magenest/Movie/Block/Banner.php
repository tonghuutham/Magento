<?php

namespace Magenest\Movie\Block;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Model\Context;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\View\Element\Template;

class Banner extends Template
{
    protected $groupRepository;
    protected $httpContext;
    private $customerRepositoryInterface;

    public function __construct(
        Template\Context            $context,
        CustomerRepositoryInterface $customerRepositoryInterface,
        GroupRepositoryInterface    $groupRepository,
        HttpContext                 $httpContext,
        array                       $data = []
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->groupRepository = $groupRepository;
        $this->httpContext = $httpContext;
        parent::__construct($context, $data);
    }

    public function isGroupB2B()
    {
        if ($this->httpContext->getValue(Context::CONTEXT_AUTH)) {
            $groupId = $this->httpContext->getValue(CustomerContext::CONTEXT_GROUP);
            $group = $this->groupRepository->getById($groupId);
            return $group->getCode() == "B2B";
        }

        return false;
    }
}
