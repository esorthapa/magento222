<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 1/3/18
 * Time: 2:38 PM
 */

namespace Javra\Javraevents\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $table_javra_Javraevents_store = $setup->getConnection()
                ->newTable(
                    $setup->getTable(
                        'javra_events_store'
                    )
                );
            $table_javra_Javraevents_store->addColumn(
                'post_id',
                Table::TYPE_SMALLINT,
                null,
                array(
                    'nullable' => false,
                    'primary' => true
                ),
                'Post Id'
            );

            $table_javra_Javraevents_store->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                array(
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ),
                'Store Id'
            );

            $table_javra_Javraevents_store->addIndex(
                $installer->getIdxName('javra_events_store', ['store_id']),
                ['store_id']
            );


            $table_javra_Javraevents_store->addForeignKey(
                $installer->getFkName('javra_events_store', 'post_id', 'javra_events', 'post_id'),
                'post_id',
                $installer->getTable('javra_events'),
                'post_id',
                Table::ACTION_CASCADE
            );

            $table_javra_Javraevents_store->addForeignKey(
                $installer->getFkName('javra_events_store', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );


            $table_javra_Javraevents_store->setComment('Post To Store Linkage Table');


            $setup->getConnection()->createTable($table_javra_Javraevents_store);

        }

        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $tableName = $setup->getTable('javra_events');
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                $table_javra_Javraevents = $setup->getConnection();
                $table_javra_Javraevents->changeColumn(
                    $tableName,
                    'creation_time',
                    'creation_time',
                    [
                        'type' => Table::TYPE_TIMESTAMP,
                        'nullable' => false,
                        'default' => Table::TIMESTAMP_INIT
                    ]
                );
                $table_javra_Javraevents->changeColumn(
                    $tableName,
                    'update_time',
                    'update_time',
                    [
                        'type' => Table::TYPE_TIMESTAMP,
                        'nullable' => false,
                        'default' => Table::TIMESTAMP_INIT_UPDATE
                    ]
                );

                /*Add new cloumn in table
                 *
                 */

                $table_javra_Javraevents->addColumn(
                    $tableName,
                    'location',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Location'
                    ]

                );

                $table_javra_Javraevents->addColumn(
                    $tableName,
                    'country',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Country'
                    ]

                );

                $table_javra_Javraevents->addColumn(
                    $tableName,
                    'city',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'City'

                    ]
                );

                $table_javra_Javraevents->addColumn(
                    $tableName,
                    'short_description',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Short Description'
                    ]

                );
            }
        }else if(version_compare($context->getVersion(), '1.0.5', '<')){
            $tableName = $setup->getTable('javra_events');
            $fullTextIntex = array('title','url_key'); // Column with fulltext index, you can put multiple fields
            $setup->getConnection()->addIndex(
                $tableName,
                $setup->getIdxName($tableName, $fullTextIntex, \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT),
                $fullTextIntex,
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }


        $installer->endSetup();
    }

}