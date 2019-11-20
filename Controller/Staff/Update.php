<?php

namespace Magenest\Staff\Controller\Staff;

use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use mysql_xdevapi\Exception;

class Update extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\View\Result\PageddFactory
     * protected $resultPageFactory;
     */
    private $resultPageFactory;
    private $customerSession;
    private $customerRepository;
    private $staff;
    protected $cacheTypeList;
    protected $cacheFrontendPool;
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                                \Magento\Customer\Model\Session $customerSession,
                                \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
                                \Magenest\Staff\Model\StaffFactory $staff,
                                TypeListInterface $cacheTypeList,
                                Pool $cacheFrontendPool
    )
    {
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
        $this->staff = $staff;
        $this->customerRepository = $customerRepository;
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }


    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        try {
            $type = $this->getRequest()->getParam("type");
            $name = $this->getRequest()->getParam("name");
            //Save customer attribute
            $customerId = $this->customerSession->getCustomer()->getId();
            $customer = $this->customerRepository->getById($customerId);
            $customer->setFirstname($name);
            $customer->setCustomAttribute('staff_type', $type);
            $this->customerRepository->save($customer);
            //Save table
            $staffTable = $this->staff->create()->load($customerId,'customer_id');
            $staffTable->setType($type);
            $staffTable->setNickName($name);
            $staffTable->save();
            //cache clean
            $_types = 'block_html';
            $this->cacheTypeList->cleanType($_types);
            foreach ($this->cacheFrontendPool as $cacheFrontend) {
                $cacheFrontend->getBackend()->clean();
            }
            return $resultPage->setData(
                [
                    'result' => 'true'
                ]
            );
        } catch (\Exception $e) {
            return $resultPage->setData(
                [
                    'result' => 'false',
                    'error' => __($e->getMessage())
                ]
            );
        }
    }
}