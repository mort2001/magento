<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
declare(strict_types=1);

namespace Amasty\Groupcat\Model\OptionSource\Rule;

use Magento\Framework\Data\OptionSourceInterface;

class PriceAction implements OptionSourceInterface
{
    public const SHOW = 0;
    public const HIDE = 1;
    public const REPLACE = 2;
    public const REPLACE_TO_REQUEST_FORM = 3;

    public function toOptionArray(): array
    {
        return [
            ['value' => self::SHOW, 'label' => __('Show')],
            ['value' => self::HIDE, 'label' => __('Hide')],
            ['value' => self::REPLACE, 'label' => __('Replace')],
            ['value' => self::REPLACE_TO_REQUEST_FORM, 'label' => __('Replace to request form')]
        ];
    }
}
