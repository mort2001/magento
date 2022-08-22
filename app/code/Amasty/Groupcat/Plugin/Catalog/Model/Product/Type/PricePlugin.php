<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Plugin\Catalog\Model\Product\Type;

class PricePlugin
{
    /**
     * @var \Amasty\Groupcat\Model\Rule\Pricing\Render
     */
    private $pricingRender;

    public function __construct(\Amasty\Groupcat\Model\Rule\Pricing\Render $pricingRender)
    {
        $this->pricingRender = $pricingRender;
    }

    /**
     * @param \Magento\Catalog\Model\Product\Type\Price $subject
     * @param callable                                  $proceed
     * @param \Magento\Catalog\Model\Product            $product
     *
     * @return int
     */
    public function aroundGetPrice(\Magento\Catalog\Model\Product\Type\Price $subject, callable $proceed, $product)
    {
        if (!$this->pricingRender->isNeedRenderPrice($product, [])) {
            return 0;
        }

        return $proceed($product);
    }
}
