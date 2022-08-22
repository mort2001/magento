<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
declare(strict_types=1);

namespace Amasty\GroupAssign\Model\Rule\Condition\Address;

use Amasty\GroupAssign\Model\Rule\Condition\Address;
use Magento\Customer\Api\Data\AddressInterface;

class Shipping extends Address
{
    /**
     * @var string
     */
    protected $type = 'shipping';

    public function loadAttributeOptions()
    {
        $attributes = [
            AddressInterface::POSTCODE => __('Shipping Postcode'),
            AddressInterface::COUNTRY_ID => __('Shipping Country'),
            AddressInterface::REGION_ID => __('Shipping State/Province'),
            AddressInterface::CITY => __('Shipping City'),
            AddressInterface::COMPANY => __('Shipping Company'),
            AddressInterface::VAT_ID => __('Shipping Vat Number'),
        ];

        $this->setAttributeOption($attributes);

        return $this;
    }
}
