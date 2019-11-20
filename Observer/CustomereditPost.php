<?php

namespace Magenest\Staff\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class CustomereditPost implements ObserverInterface
{
    protected $_request;
    protected $_layout;
    protected $_objectManager = null;
    protected $_customerGroup;
    private $logger;
    protected $_customerRepositoryInterface;
    protected $staffFactory;
    private $_registry;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magenest\Staff\Model\StaffFactory $staffFactory,
        \Magento\Framework\Registry $registry
    )
    {
        $this->_registry = $registry;
        $this->staffFactory = $staffFactory;
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->logger = $logger;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public
    function execute(EventObserver $observer)
    {
        $customer = $observer->getCustomerDataObject();
        $customerId = $customer->getId();
        if ($this->_registry->registry('customer_save_observer_executed_' . $customer->getId()))
            return $this;

        $attribute = $this->_customerRepositoryInterface->getById($customerId);
        $value = $attribute->getCustomAttribute('staff_type')->getValue();
        $firstName = $customer->getFirstName();
        $lastName = $customer->getLastName();
        $staff = $this->staffFactory->create();
        $staff->setCustomerId($customerId);
        $nickName = $firstName . ' ' . $lastName;
        $staff->setNickName($nickName);
        $staff->setStatus(2);
        $staff->setType($value);
        $staff->save();

        $this->_registry->register('customer_save_observer_executed_' . $customer->getId(), true);
        return $this;
    }
}