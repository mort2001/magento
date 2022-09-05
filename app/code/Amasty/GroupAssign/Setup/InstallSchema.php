<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Customer Group Auto Assign for Magento 2
*/

namespace Amasty\GroupAssign\Setup;

use Amasty\GroupAssign\Setup\Operation\CreateRuleTable;
use Amasty\GroupAssign\Setup\Operation\CreateCustomerGroupTable;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var CreateRuleTable
     */
    private $ruleTable;

    /**
     * @var CreateCustomerGroupTable
     */
    private $customerGroupTable;

    public function __construct(
        CreateRuleTable $ruleTable,
        CreateCustomerGroupTable $customerGroupTable
    ) {
        $this->ruleTable = $ruleTable;
        $this->customerGroupTable = $customerGroupTable;
    }

    /**
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->ruleTable->execute($setup);
        $this->customerGroupTable->execute($setup);

        $setup->endSetup();
    }
}
