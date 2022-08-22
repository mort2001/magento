<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Plugin\Catalog\Model\Product;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\ViewModel\Product\Checker\AddToCompareAvailability;
use Magento\Catalog\Api\Data\ProductInterface;
use Amasty\Groupcat\Model\ProductRuleProvider;
use Amasty\Groupcat\Helper\Data;
use Magento\CatalogInventory\Api\StockConfigurationInterface;

class IsCompare
{
    /**
     * @var ProductRuleProvider
     */
    private $ruleProvider;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var StockConfigurationInterface
     */
    private $stockConfiguration;

    public function __construct(
        ProductRuleProvider $ruleProvider,
        Data $helper,
        StockConfigurationInterface $stockConfiguration
    ) {
        $this->ruleProvider = $ruleProvider;
        $this->helper = $helper;
        $this->stockConfiguration = $stockConfiguration;
    }

    /**
     * @param AddToCompareAvailability $subject
     * @param $result
     * @param ProductInterface $product
     * @return bool
     */
    public function afterIsAvailableForCompare(
        AddToCompareAvailability $subject,
        $result,
        ProductInterface $product
    ): bool {
        if ($this->helper->isModuleEnabled() && $this->ruleProvider->getProductIsHideCompare($product)) {
            $result = false;
        }

        if ((int)$product->getStatus() !== Status::STATUS_DISABLED) {
            return $product->getOrigData('is_salable') || $this->stockConfiguration->isShowOutOfStock();
        }

        return $result;
    }
}
