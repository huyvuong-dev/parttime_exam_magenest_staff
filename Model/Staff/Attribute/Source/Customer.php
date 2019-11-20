<?php
/**
 * A Magento 2 module named Ewall/HelpDesk
 * Copyright (C) 2017  Ewall Solutions Pvt Ltd
 *
 */
namespace Magenest\Staff\Model\Staff\Attribute\Source;
class Customer implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Ewall\HelpDesk\Api\GroupRepositoryInterface
     */
    private $directorRepositoryInterface;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Convert\DataObject
     */
    private $objectConverter;

    private $_collectionFactory;
    /**
     * @param \Ewall\HelpDesk\Api\DepartmentRepositoryInterface $departmentRepositoryInterface
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Convert\DataObject $objectConverter
     * @param \Ewall\HelpDesk\Model\ResourceModel\Department\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Convert\DataObject $objectConverter,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $collectionFactory
    )
    {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->objectConverter = $objectConverter;
        $this->_collectionFactory = $collectionFactory;
    }

    public function toOptionArray($addEmpty = true)
    {
        /** @var \Magenest\Staff\Model\ResourceModel\Staff\Collection $collection */

        $customers = $this->_collectionFactory->create();
        $options = [];
        if ($addEmpty) {
            $options[] = ['label' => __('-- Please Select a Customer --'), 'value' => ''];
        }
        foreach ($customers as $customer) {
            $options[] = ['label' => $customer->getId(), 'value' => $customer->getId()];
        }
        return $options;
    }
}