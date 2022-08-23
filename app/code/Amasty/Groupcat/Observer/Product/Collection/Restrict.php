<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Observer\Product\Collection;

use Magento\Framework\Event\ObserverInterface;

/**
 * observer for event catalog_product_collection_load_before
 */
class Restrict implements ObserverInterface
{
    use \Amasty\Groupcat\Observer\CatalogCollectionTrait;
    /**
     * @var \Amasty\Groupcat\Model\ProductRuleProvider
     */
    private $ruleProvider;

    /**
     * @var \Amasty\Groupcat\Helper\Data
     */
    private $helper;

    public function __construct(
        \Amasty\Groupcat\Model\ProductRuleProvider $ruleProvider,
        \Amasty\Groupcat\Helper\Data $helper
    ) {
        $this->ruleProvider = $ruleProvider;
        $this->helper       = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->helper->isModuleEnabled()) {
            $this->restrictCollectionIds(
                $observer->getEvent()->getCollection(),
                $this->ruleProvider->getRestrictedProductIds()
            );
        }
    }
}