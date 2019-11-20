<?php
namespace Magenest\Staff\Controller\Adminhtml\Staff;

use Magenest\Staff\Model\Staff as Staff;
use Magento\Backend\App\Action;


class AddStaff extends \Magento\Backend\App\Action
{
    /**
     * Edit A Contact Page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
        $staffDatas = $this->getRequest()->getParam('staff');
        if(is_array($staffDatas)) {
            $staff = $this->_objectManager->create(Staff::class);
            $staff->setData($staffDatas);
            $staff->setData($staffDatas)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index');
        }
    }

}