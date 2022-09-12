<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Controller\Payment;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;
use Zend_Log_Exception;

/**
 * Class Index
 * @package Tigren\AdvancedCheckout\Controller\Payment
 */
class Index extends Action
{
    protected $_collectionFactory;
    /**
     * @var SerializerInterface
     */
    protected $serializer;
    /**
     * @var CheckoutSession
     */
    protected $_checkoutSession;
    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @param Context $context
     * @param ProductRepository $productRepository
     * @param CheckoutSession $checkoutSession
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Context             $context,
        ProductRepository   $productRepository,
        CheckoutSession     $checkoutSession,
        SerializerInterface $serializer,
        CollectionFactory   $collectionFactory
    )
    {
        $this->_collectionFactory = $collectionFactory;
        $this->serializer = $serializer;
        $this->_checkoutSession = $checkoutSession;
        $this->_productRepository = $productRepository;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @throws Zend_Log_Exception
     */
    public function execute()
    {
        $result = [];
        $sku = $this->getRequest()->getParam('productSku');
        $product = $this->_productRepository->get($sku);
        $multi_orders = $product->getCustomAttribute('custom_product_attribute') ? $product->getCustomAttribute('custom_product_attribute')->getValue() : '';
        $check_product = $this->_checkoutSession->getQuote()->getItemsCollection();
        $cart_sku = $check_product
            ->addFieldToFilter('sku', $sku);
        $a = 0;
        foreach ($cart_sku as $cart) {
            if ($cart['sku'] == $sku) {
                $a++;
            }
        }
        if ($multi_orders == 0 && $a > 0) {
            $result['ClearCart'] = true;
        } else {
            $result['ClearCart'] = false;
        }

        return $this->getResponse()->representJson($this->serializer->serialize($result));
    }
}