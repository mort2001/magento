<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
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
