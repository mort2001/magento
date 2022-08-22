<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Amasty\Groupcat\Plugin\Indexer\Product\Save;

use Amasty\Groupcat\Model\Indexer\Product\ProductRuleProcessor;

class ApplyRules
{
    /**
     * @var ProductRuleProcessor
     */
    protected $productRuleProcessor;

    public function __construct(ProductRuleProcessor $productRuleProcessor)
    {
        $this->productRuleProcessor = $productRuleProcessor;
    }

    /**
     * Apply groupcat rules after product resource model save
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product $subject
     * @param callable $proceed
     * @param \Magento\Framework\Model\AbstractModel $product
     * @return \Magento\Catalog\Model\ResourceModel\Product
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundSave(
        \Magento\Catalog\Model\ResourceModel\Product $subject,
        callable $proceed,
        \Magento\Framework\Model\AbstractModel $product
    ) {
        $productResource = $proceed($product);
        if (!$product->getIsMassupdate()) {
            $this->productRuleProcessor->reindexRow($product->getId());
        }
        return $productResource;
    }
}
