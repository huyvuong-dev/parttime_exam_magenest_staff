<?php

namespace Magenest\Staff\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
    private $customerSetupFactory;


    private $attributeSetFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(\Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory,
                                \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory)
    {
        $this->attributeSetFactory = $attributeSetFactory;
        $this->customerSetupFactory= $customerSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        /** @var $attributeSet AttributeSet */
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSet = $this->attributeSetFactory->create();
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $setup->startSetup();
        $attributeCode = 'staff_type';
        $customerSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            $attributeCode, [
            'type'         => 'text',
            'label'        => 'Magenest Staff',
            'input'        => 'select',
            'required'     => false,
            'visible'      => true,
            'user_defined' => true,
            'position'     => 999,
            'system'       => 0,
            'source'       => \Magenest\Staff\Model\Customer\Attribute\Source\Level::class
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            $attributeCode
        );
        $attribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer'],
        ]);
        $attribute->save();
        $setup->endSetup();
    }
}