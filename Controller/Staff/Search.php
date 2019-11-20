<?php
namespace Magenest\Staff\Controller\Staff;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
class Search extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\View\Result\PageddFactory
    protected $resultPageFactory;
     */
    private $resultPageFactory;
    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Search Staff'));

        $block = $resultPage->getLayout()->getBlock('customer.account.link.back');
        if ($block) {
            $block->setRefererUrl($this->_redirect->getRefererUrl());
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create(\Magento\Customer\Model\Session::class);
        $id = $customerSession->getCustomer()->getId();
        if (!isset($id)){
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('customer/account');
        }
        return $resultPage;
    }
}