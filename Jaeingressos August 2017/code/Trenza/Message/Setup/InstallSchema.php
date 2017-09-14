<?php

namespace Trenza\Message\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
		$installer = $setup;
		$installer->startSetup();

		/**
		 * Creating table Trenza_message
		 */
		$table = $installer->getConnection()->newTable(
			$installer->getTable('Trenza_message')
		)->addColumn(
			'id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Message Id'
		)->addColumn(
			'product_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => true,'default' => null],
			'Product Id'
		)->addColumn(
			'seller_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => false],
			'Seller Id'
		)->addColumn(
			'buyer_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => false],
			'Buyer Id'
		)->addColumn(
			'parent_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => true,'default' => 0],
			'Parent Message Id'
		)->addColumn(
			'message',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			'2M',
			['nullable' => false],
			'Message Content'
		)->addColumn(
			'seller_read_flg',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => true,'default' => 0],
			'Seller Read Flag'
		)->addColumn(
			'buyer_read_flg',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => true,'default' => 0],
			'Buyer Read Flag'
		)->addColumn(
			'seller_delete_flg',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => true,'default' => 0],
			'Seller Delete Flag'
		)->addColumn(
			'buyer_delete_flg',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => true,'default' => 0],
			'Buyer Delete Flag'
		)->addColumn(
			'sender_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => false],
			'Sender Id'
		)->addColumn(
			'reciver_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			20,
			['nullable' => false],
			'Receiver Id'
		)->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Message Created At'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Message Updated At'
            )
            ->addIndex(
			$installer->getIdxName(
				'Trenza_message',
				['updated_at'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
			),
			['updated_at'],
			['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX]
		)->setComment(
			'Message'
		);
		$installer->getConnection()->createTable($table);
		$installer->endSetup();
	}
}