<?php

/**
 * Install table
 */

namespace Preorder\Module\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('preorder_module_post')) {
                        $table = $installer->getConnection()->newTable(
                            $installer->getTable('preorder_module_post')
                        )
                        ->addColumn(
                            'preorder_id',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                            null,
                            [
                            'identity' => true,
                            'nullable' => false,
                            'primary'  => true,
                            'unsigned' => true,
                            ],
                            'Preorder ID'
                        )
                        ->addColumn(
                            'firstname',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            255,
                            ['nullable => false'],
                            'First Name'
                        )
                        ->addColumn(
                            'lastname',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            255,
                            ['nullable => false'],
                            'Last Name'
                        )
                        ->addColumn(
                            'email',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            255,
                            ['nullable => false'],
                            'Email'
                        )
                        ->addColumn(
                            'product',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            255,
                            ['nullable => false'],
                            'Products'
                        )
                        ->addColumn(
                            'sku',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            255,
                            ['nullable => false'],
                            'Sku'
                        )
                        ->addColumn(
                            'qty',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                            1,
                            [],
                            'Quantity'
                        )
                        ->addColumn(
                            'created_at',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                            null,
                            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                            'Created At'
                        )->addColumn(
                            'updated_at',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                            null,
                            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                            'Updated At'
                        )
                        ->setComment('Preorder Table');
                $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
