<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\GroupAssign\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @var Operation\CreateCustomerGroupTable
     */
    private $createCustomerGroupTable;

    public function __construct(
        Operation\CreateCustomerGroupTable $createCustomerGroupTable
    ) {
        $this->createCustomerGroupTable = $createCustomerGroupTable;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (!$context->getVersion() || version_compare($context->getVersion(), '1.0.5', '<')) {
            $this->createCustomerGroupTable->execute($setup);
        }
        $setup->endSetup();
    }
}
