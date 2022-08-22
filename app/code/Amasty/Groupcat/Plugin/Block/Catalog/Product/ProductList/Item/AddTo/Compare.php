<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Amasty\Groupcat\Plugin\Block\Catalog\Product\ProductList\Item\AddTo;

class Compare
{
    /**
     * @var \Amasty\Groupcat\Model\ProductRuleProvider
     */
    private $ruleProvider;

    public function __construct(
        \Amasty\Groupcat\Model\ProductRuleProvider $ruleProvider
    ) {
        $this->ruleProvider = $ruleProvider;
    }

    /**
     * @param \Magento\Catalog\Block\Product\ProductList\Item\AddTo\Compare $subject
     * @param \Closure $proceed
     * @return string
     */
    public function aroundToHtml($subject, $proceed)
    {
        if ($this->ruleProvider->getProductIsHideCompare($subject->getProduct())) {
            return '';
        }
        return $proceed();
    }
}
