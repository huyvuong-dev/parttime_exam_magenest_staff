<?php

namespace Magenest\Staff\Controller\Staff;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class AjaxSearch extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\View\Result\PageddFactory
     * protected $resultPageFactory;
     */
    private $resultPageFactory;
    private $staffCollection;
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                                \Magenest\Staff\Model\ResourceModel\Staff\CollectionFactory $staffCollection

    )
    {
        $this->staffCollection = $staffCollection;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $content = $this->getRequest()->getParam('content');
        $output = [];
        $names = $this->staffCollection->create()->addFieldToSelect('*')->addFieldToFilter('nick_name',array('like' => '%'.$content.'%'));
        foreach ($names as $name) {
            $output[] = $name['nick_name'];
        }


        return $resultPage->setData(
            [
                'result' => $output
            ]
        );

    }
}