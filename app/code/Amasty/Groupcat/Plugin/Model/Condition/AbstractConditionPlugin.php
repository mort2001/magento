<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Plugin\Model\Condition;

class AbstractConditionPlugin
{
    /**
     * fix Magento issue - validate by multiselect
     *
     * @param \Magento\Rule\Model\Condition\AbstractCondition $subject
     * @param array|string|int|float                          $result
     *
     * @return array|string|int|float
     */
    public function afterGetValueParsed(\Magento\Rule\Model\Condition\AbstractCondition $subject, $result)
    {
        $value = $subject->getData('value');
        if ($subject->isArrayOperatorType() && is_array($value)) {
            return $value;
        }

        return $result;
    }
}
