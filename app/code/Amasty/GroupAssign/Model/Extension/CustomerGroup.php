<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\GroupAssign\Model\Extension;

use Amasty\GroupAssign\Model\ResourceModel\Extension\CustomerGroup as CustomerGroupResource;
use Magento\Framework\Model\AbstractModel;

class CustomerGroup extends AbstractModel
{
    public const ID = 'id';
    public const GROUP_ID = 'group_id';
    public const IS_VISIBLE_ON_STOREFRONT = 'is_visible_on_storefront';

    public function _construct()
    {
        $this->_init(CustomerGroupResource::class);
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function getGroupId(): int
    {
        return $this->getData(self::GROUP_ID);
    }

    public function setGroupId(int $groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }

    public function getIsVisibleOnStorefront(): ?bool
    {
        return $this->getData(self::IS_VISIBLE_ON_STOREFRONT);
    }

    public function setIsVisibleOnStorefront(bool $isVisibleOnStorefront)
    {
        return $this->setData(self::IS_VISIBLE_ON_STOREFRONT, $isVisibleOnStorefront);
    }
}
