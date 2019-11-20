<?php
namespace Magenest\Staff\Setup;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface{
    public function install(SchemaSetupInterface $setup,ModuleContextInterface $context){
        $setup->startSetup();
        $conn = $setup->getConnection();
        $tableName = $setup->getTable('magenest_staff');
        if($conn->isTableExists($tableName) != true){
            $table = $conn->newTable($tableName)
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity'=>true, 'unsigned'=>true, 'nullable'=>false, 'primary' => true],
                    'ID'
                )->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    64,
                    ['nullable' => false],
                    'Customer Id'
                )
                ->addColumn(
                    'nick_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Nick Name'
                )
                ->addColumn(
                    'type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    1,
                    [],
                    'Type'
                )->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    1,
                    ['nullable' => false],
                    'Status'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,[
                    'nullable' => false,
                    'default' =>
                        \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
                ],
                    'Updated At'
                )
                ->setComment('Staff Table');
            $conn->createTable($table);
        }
        $setup->endSetup();
    }
}
?>