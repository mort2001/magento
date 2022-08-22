<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
declare(strict_types=1);

namespace Amasty\Groupcat\Model\OptionSource\Rule;

use Magento\Framework\Data\OptionSourceInterface;

class DirectLinks implements OptionSourceInterface
{
    public const DENY = 0;
    public const ALLOW = 1;

    public function toOptionArray(): array
    {
        return [
            ['value' => self::DENY, 'label' => __('Deny')],
            ['value' => self::ALLOW, 'label' => __('Allow')]
        ];
    }
}
