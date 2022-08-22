<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\GroupAssign\Model\ResourceModel\Rule;

use Amasty\GroupAssign\Model\Rule;
use Amasty\GroupAssign\Model\ResourceModel\Rule as RuleResource;
use Magento\Rule\Model\ResourceModel\Rule\Collection\AbstractCollection;

/**
 * @method Rule[] getItems()
 */
class Collection extends AbstractCollection
{
    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _construct()
    {
        $this->_init(Rule::class, RuleResource::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }
}
