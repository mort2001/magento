<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\GroupAssign\Model\OptionSource\Rules;

use Amasty\GroupAssign\Model\Rule;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Option\ArrayInterface;

class Status implements OptionSourceInterface
{
    /**
     * @var Escaper
     */
    private $escaper;

    public function __construct(
        Escaper $escaper
    ) {
        $this->escaper = $escaper;
    }

    public function toOptionArray()
    {
        $statuses = [
            [
                'value' => Rule::STATUS_DISABLED, 'label' => '<span class="grid-severity-critical">'
                . $this->escaper->escapeHtml(__("Disabled"))
                . '</span>'
            ],
            [
                'value' => Rule::STATUS_ENABLED, 'label' => '<span class="grid-severity-notice">'
                . $this->escaper->escapeHtml(__("Enabled"))
                . '</span>'
            ]
        ];

        return $statuses;
    }
}
