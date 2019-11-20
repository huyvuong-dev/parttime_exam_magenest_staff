<?php

namespace Magenest\Staff\Controller\Adminhtml\Staff;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magenest\Staff\Model\ResourceModel\Staff\CollectionFactory;
use Magenest\Staff\Model\Staff;

class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $status = $this->getRequest()->getParam('status');
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collections = $collection->getData();
        $collectionSize = $collection->getSize();
        if ($status == 1) {
            foreach ($collections as $col) {
                $staff = $this->_objectManager->create(Staff::class)->load($col['id']);
                $staff->setData('status',1);
                $staff->save();
            }
        } else {
            foreach ($collections as $col) {
                $staff = $this->_objectManager->create(Staff::class)->load($col['id']);
                $staff->setData('status',2);
                $staff->save();
            }
        }


        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}