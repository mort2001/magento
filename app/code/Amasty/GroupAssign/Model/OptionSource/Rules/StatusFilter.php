<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\GroupAssign\Model\OptionSource\Rules;

use Magento\Framework\Option\ArrayInterface;
use Amasty\GroupAssign\Model\Rule;

class StatusFilter implements ArrayInterface
{
    public function toOptionArray()
    {
        $statuses = [
            [
                'value' => Rule::STATUS_DISABLED,
                'label' => __('Disabled')
            ],
            [
                'value' => Rule::STATUS_ENABLED,
                'label' => __('Enabled')
            ]
        ];

        return $statuses;
    }
}
