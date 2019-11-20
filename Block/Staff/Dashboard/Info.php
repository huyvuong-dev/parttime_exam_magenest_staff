<?php
namespace Magenest\Staff\Block\Staff\Dashboard;

class Info extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    private $_customerSession;
    private $_customerRepositoryInterface;
    private $_staffFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magenest\Staff\Model\StaffFactory $staffFactory,
        array $data = []
    )
    {
        $this->_staffFactory = $staffFactory;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }
    protected function _construct()
    {
        parent::_construct();
    }

    public function getType(){
        $customerId = $this->_customerSession->create()->getCustomer()->getId();
        if ($customerId){
            $staff = $this->_staffFactory->create()->load($customerId,'customer_id');
            $type = $staff->getType();
            return $type;
        }
    }

    public function getName(){
        $customerId = $this->_customerSession->create()->getCustomer()->getId();
        if ($customerId){
            $staff = $this->_staffFactory->create()->load($customerId,'customer_id');
            $name = $staff->getNickName();
            return $name;
        }
    }
    public function getUpdateUrl(){
        return $this->getBaseUrl().'manage/staff/update';
    }

}