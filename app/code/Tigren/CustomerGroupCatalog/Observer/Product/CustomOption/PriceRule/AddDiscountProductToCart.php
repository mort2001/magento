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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Session;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;

/**
 * Class Addtocart
 * @package Vendor\Module\Observer\Product\CustomOption\PriceRule
 */
class AddDiscountProductToCart implements ObserverInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var Session
     */
    protected $_session;
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

    /**
     * @param Product $product
     * @param StoreManagerInterface $storeManager
     * @param RequestInterface $request
     * @param Session $session
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Product               $product,
        StoreManagerInterface $storeManager,
        RequestInterface      $request,
        Session               $session,
        CollectionFactory     $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->_session = $session;
        $this->_product = $product;
        $this->_storeManager = $storeManager;
        $this->_request = $request;
    }

    /**
     * @param Observer $observer
     * @throws NoSuchEntityException|LocalizedException
     */
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getData('product');
        $sku = $product->getSku();

        if ($this->_session->isLoggedIn()) {
            $group_id = $this->_session->getCustomerGroupId();
            $ruleCollection = $this->collectionFactory->create()
                ->addFieldToFilter('products', ['like' => '%' . $sku . '%'])
                ->addFieldToFilter('customer_group_ids', $group_id);
            $priority = $ruleCollection->getColumnValues('priority');
            $priority_collection = $this->collectionFactory->create()->addFieldToFilter('priority', min($priority));
            $discount = $priority_collection->getColumnValues('discount_amount');

            $item = $observer->getEvent()->getData('quote_item');
            $item = ($item->getParentItem() ? $item->getParentItem() : $item);
            $integerIDs = array_map('intval', $discount);
            foreach ($integerIDs as $percent) {
                $percent = $percent / 100;
            }

            $sku = $item->getSku();
            $productCollection = $this->_product->loadByAttribute('sku', $sku);
            $productPriceBySku = $productCollection->getPrice();
            $customPrice = $productPriceBySku - ($productPriceBySku * $percent); // custom price
            $item->setCustomPrice($customPrice);
            $item->setOriginalCustomPrice($customPrice);
            $item->getProduct()->setIsSuperMode(true);
        }
    }
}