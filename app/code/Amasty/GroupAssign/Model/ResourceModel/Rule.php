<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Customer Group Auto Assign for Magento 2
*/

namespace Amasty\GroupAssign\Model\ResourceModel;

use Amasty\GroupAssign\Setup\Operation\CreateRuleTable;
use Magento\Rule\Model\ResourceModel\AbstractResource;

class Rule extends AbstractResource
{
    public function _construct()
    {
        $this->_init(CreateRuleTable::TABLE_NAME, 'id');
    }
}
