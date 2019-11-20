<?php

namespace Magenest\Staff\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\Controller\ResultFactory;
class CustomerLogin implements ObserverInterface
{
    protected $cacheTypeList;
    protected $cacheFrontendPool;
    private $resultFactory;
    public function __construct(
        TypeListInterface $cacheTypeList,
        Pool $cacheFrontendPool,
        ResultFactory $resultFactory
    ){
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
        $this->resultFactory = $resultFactory;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_types = 'block_html';
        $this->cacheTypeList->cleanType($_types);
        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('/');
    }
}