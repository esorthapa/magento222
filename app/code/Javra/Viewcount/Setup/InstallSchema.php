<?php
/**
 * This Module is generate number of count which like by user.
 * Copyright (C) 2017 www.javra.com
 *
 * This file is part of Javra/Viewcount.
 *
 * Javra/Viewcount is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Javra\Viewcount\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $installer = $setup;
        $installer->startSetup();

        $table_name = $installer->getTable('javra_viewcount_count');
        $table_javra_viewcount_count = $setup->getConnection()->newTable($setup->getTable('javra_viewcount_count'));

        if ($installer->getConnection()->isTableExists($table_name) != true) {
            $table_javra_viewcount_count->addColumn(
                'count_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array('identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,),
                'ID'
            );


            $table_javra_viewcount_count->addColumn(
                'count',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Count'
            );

            $table_javra_viewcount_count->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Title'
            );

            $table_javra_viewcount_count->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Created At'
            );

            $table_javra_viewcount_count->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Updated At'
            );
            $table_javra_viewcount_count->setComment('ViewCount Table');
            $table_javra_viewcount_count->setOption('type', 'InnoDB');
            $table_javra_viewcount_count->setOption('charset', 'utf8');


            $setup->getConnection()->createTable($table_javra_viewcount_count);

            $setup->endSetup();
        }
    }
}
