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
use Magento\Customer\Model\Session;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;

/**
 * Class Addtocart
 * @package Vendor\Module\Observer\Product\CustomOption\PriceRule
 */
class Addtocart implements ObserverInterface
{
    protected $collectionFactory;
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

    public function __construct(
        Product               $product,
        StoreManagerInterface $storeManager,
        RequestInterface      $request,
        Session $session,
        CollectionFactory $collectionFactory
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
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {

        if($this->_session->isLoggedIn()){
            $cusgroup_id = $this->_session->getCustomerGroupId();
            $this->collectionFactory->create();
        }
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