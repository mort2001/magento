<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\GroupAssign\Model\ResourceModel\Extension;

use Amasty\GroupAssign\Model\Extension\CustomerGroup as CustomerGroupModel;
use Magento\Rule\Model\ResourceModel\AbstractResource;

class CustomerGroup extends AbstractResource
{
    public const TABLE_NAME = 'amasty_groupassign_customer_group';

    public function _construct()
    {
        $this->_init(self::TABLE_NAME, CustomerGroupModel::ID);
    }
}
