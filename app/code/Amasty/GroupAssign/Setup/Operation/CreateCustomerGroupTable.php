<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Customer Group Auto Assign for Magento 2
*/

namespace Amasty\GroupAssign\Setup\Operation;

use Amasty\GroupAssign\Model\Extension\CustomerGroup;
use Amasty\GroupAssign\Model\ResourceModel\Extension\CustomerGroup as CustomerGroupResource;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Customer\Model\Group;

class CreateCustomerGroupTable
{
    /**
     * @param SchemaSetupInterface $setup
     *
     * @throws \Zend_Db_Exception
     */
    public function execute(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->createTable(
            $this->createTable($setup)
        );
    }

    /**
     * @param SchemaSetupInterface $setup
     *
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function createTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getTable(CustomerGroupResource::TABLE_NAME);
        $groupsTable = $setup->getTable(Group::ENTITY);

        return $setup->getConnection()
            ->newTable(
                $table
            )->setComment(
                'Amasty Customer Group Auto Assign customer group table'
            )->addColumn(
                CustomerGroup::ID,
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary'  => true
                ],
                'Id'
            )->addColumn(
                CustomerGroup::GROUP_ID,
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false
                ],
                'Customer group id'
            )->addColumn(
                CustomerGroup::IS_VISIBLE_ON_STOREFRONT,
                Table::TYPE_BOOLEAN,
                null,
                [
                    'nullable' => false
                ],
                'Show customer group status'
            )->addForeignKey(
                $setup->getFkName(
                    $table,
                    CustomerGroup::GROUP_ID,
                    $groupsTable,
                    'customer_group_id'
                ),
                CustomerGroup::GROUP_ID,
                $groupsTable,
                'customer_group_id',
                Table::ACTION_CASCADE
            );
    }
}
