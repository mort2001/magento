<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
declare(strict_types=1);

namespace Tigren\CustomerGroupCatalog\Model\OptionSource\Rule;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public const INACTIVE = 0;
    public const ACTIVE = 1;

    public function toOptionArray(): array
    {
        return [
            ['value' => self::ACTIVE, 'label' => __('Active')],
            ['value' => self::INACTIVE, 'label' => __('Inactive')]
        ];
    }
}
