<?php
namespace Magento\EventsReminder\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();
		if (!$installer->tableExists('utshob_evens_reminder')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('utshob_evens_reminder')
			)
				->addColumn(
					'id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'nullable' => false,
						'primary'  => true,
						'unsigned' => true,
					],
					'Events ID'
				)->addColumn(
					'customer_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					100,
					['nullable' => false,
					],
					'Customer ID'
				)
				->addColumn(
					'name',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable => false'],
					'Events Name'
				)
				->addColumn(
					'event_message',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable => false'],
					'Events Message'
				)->addColumn(
					'friend_email',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable => false'],
					'Events Firend Email'
				)
				->addColumn(
					'status',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					3,
					[],
					'Events Status'
				)
				->addColumn(
						'events_date',
						\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
						null,
						['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
						'Events Date'
				)
				->addColumn(
						'events_reminder_date',
						\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
						null,
						['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
						'Events Reminder Date'
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
					'Updated At')
				->setComment('Events Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('utshob_evens_reminder'),
				$setup->getIdxName(
					$installer->getTable('utshob_evens_reminder'),
					['name','status','event_message','friend_email'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['name','status','event_message','friend_email'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		}
		$installer->endSetup();
	}
}