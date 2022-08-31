<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Controller\Payment;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote\Item;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Checkout\Model\Cart;

/**
 * Class ClearCart
 * @package Tigren\AdvancedCheckout\Controller\Payment
 */
class ClearCart extends Action
{
    protected $_modelCart;
    /**
     * @var Item
     */
    protected $modelCartItem;
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;
    /**
     * @var SerializerInterface
     */
    protected $serializer;
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @param Context $context
     * @param SerializerInterface $serializer
     * @param ResultFactory $resultFactory
     * @param CheckoutSession $checkoutSession
     * @param Item $modelCartItem
     */
    public function __construct(Context         $context, SerializerInterface $serializer, ResultFactory $resultFactory,
                                CheckoutSession $checkoutSession, Item $modelCartItem, Cart $cart)
    {
        $this->_modelCart = $cart;
        $this->modelCartItem = $modelCartItem;
        $this->checkoutSession = $checkoutSession;
        $this->resultFactory = $resultFactory;
        $this->serializer = $serializer;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Json&ResultInterface
     */
    public function execute()
    {
        $status = $this->getRequest()->getParams();
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info(print_r($status, true));
        if ($status) {
            $all_items = $this->checkoutSession->getQuote()->getAllVisibleItems();
            foreach($all_items as $items)
            {
                $itemId = $items->getItemId();
                $this->_modelCart->removeItem($itemId)->save();
            }
        }

        $response = $this->resultFactory
            ->create(ResultFactory::TYPE_JSON)
            ->setData([
                'status' => "ok",
                'message' => "form submitted correctly"
            ]);
        return $response;
    }
}