<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Model\Rule;

class ForbiddenActionOptionsProvider implements \Magento\Framework\Data\OptionSourceInterface
{
    public const REDIRECT_TO_404 = 0;
    public const REDIRECT_TO_PAGE = 1;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::REDIRECT_TO_404, 'label' => __('Show 404 page')],
            ['value' => self::REDIRECT_TO_PAGE, 'label' => __('Redirect to CMS page')]
        ];
    }
}
