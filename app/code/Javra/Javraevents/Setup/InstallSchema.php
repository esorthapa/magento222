<?php
namespace Javra\Javraevents\Setup;


use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface {
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('javra_events'))
            ->addColumn(
                'post_id',
                Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Post ID'
            )
            ->addColumn('url_key', Table::TYPE_TEXT, 100, ['nullable' => true, 'default' => null], 'Url Key')
            ->addColumn('title', Table::TYPE_TEXT, 255, ['nullable' => false], 'Blog Title')
            ->addColumn('content', Table::TYPE_TEXT, '2M', [], 'Blog Content')
            ->addColumn('image',Table::TYPE_TEXT, 255, ['nullable' => false],'Image Url')
            ->addColumn('is_active', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Is Post Active?')
            ->addColumn('type', Table::TYPE_SMALLINT, 10, ['nullable' => true], 'New Event Type')
            ->addColumn('start_date', Table::TYPE_DATETIME, null,['nullable'=>false],'Start Date' )
            ->addColumn('end_date',Table::TYPE_DATETIME, null,['nullable'=>false], 'End Date')
            ->addColumn('created_by', Table::TYPE_TEXT, 255, ['nullable' => true], 'Created By')
            ->addColumn('creation_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation Time')
            ->addColumn('update_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Update Time')
            ->addIndex($installer->getIdxName('blog_post', ['url_key']), ['url_key'])
            ->setComment('Javra Blog events');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
