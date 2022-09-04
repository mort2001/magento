<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Observer;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\OrderCustomerManagementInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\OrderFactory;
use Magento\Store\Model\StoreManagerInterface;

class ConvertGuest implements ObserverInterface
{

    public function __construct(
        StoreManagerInterface            $storeManager,
        OrderCustomerManagementInterface $orderCustomerService,
        OrderFactory                     $orderFactory,
        OrderRepositoryInterface         $orderRepository,
        CustomerFactory                  $customer
    )
    {
        $this->_storeManager = $storeManager;
        $this->orderCustomerService = $orderCustomerService;
        $this->_orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
        $this->_customer = $customer;
    }

    public function execute(Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        $orderId = $orderIds[0];
        $order = $this->_orderFactory->create()->load($orderId);

        $customer = $this->_customer->create();

        $customer->setWebsiteId($this->_storeManager->getStore()->getWebsiteId());
        $customer->loadByEmail($order->getCustomerEmail());

        //Convert guest into customer
        if ($order->getId() && !$customer->getId()) {
            $this->orderCustomerService->create($orderId);
        } else {
        //if customer Registered and checkout as guest
            $order->setCustomerId($customer->getId());
            $order->setCustomerIsGuest(0);
            $this->orderRepository->save($order);
        }
    }
}