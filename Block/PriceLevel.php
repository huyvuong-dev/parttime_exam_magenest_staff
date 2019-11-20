<?php
namespace Magenest\Staff\Block;

class PriceLevel extends \Magento\Framework\View\Element\Template
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

    public function getType(){
        $result = '';
        $customerId = $this->_customerSession->create()->getCustomer()->getId();
        if ($customerId){
            $staff = $this->_staffFactory->create()->load($customerId,'customer_id');
            $type = $staff->getType();
            if ($type){
                if ($type == 1)
                    $result = '(lv1)';
                elseif($type == 2)
                    $result = '(lv2)';
                else
                    $result = '';
            }
        }
        return $result;
    }

}