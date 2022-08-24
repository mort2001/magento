<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Observer\Product\CustomOption\PriceRule;

use Magento\Catalog\Model\Product;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Addtocart
 * @package Vendor\Module\Observer\Product\CustomOption\PriceRule
 */
class Addtocart implements ObserverInterface
{

    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var Product
     */
    protected $_product;

    public function __construct(
        Product               $product,
        StoreManagerInterface $storeManager,
        RequestInterface      $request
    )
    {
        $this->_product = $product;
        $this->_storeManager = $storeManager;
        $this->_request = $request;
    }

    /**
     * @param Observer $observer
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $item = $observer->getEvent()->getData('quote_item');
        $item = ($item->getParentItem() ? $item->getParentItem() : $item);
        $percentFactor = 0.2; //giving 20% discount
        $sku = $item->getSku();
        $productCollection = $this->_product->loadByAttribute('sku', $sku);
        $productPriceBySku = $productCollection->getPrice();
        $customPrice = $productPriceBySku - ($productPriceBySku * $percentFactor); // custom price
        $item->setCustomPrice($customPrice);
        $item->setOriginalCustomPrice($customPrice);
        $item->getProduct()->setIsSuperMode(true);
    }
}