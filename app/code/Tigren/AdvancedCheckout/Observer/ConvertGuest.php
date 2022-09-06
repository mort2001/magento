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
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderCustomerManagementInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\OrderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

/**
 * Class ConvertGuest
 * @package Tigren\AdvancedCheckout\Observer
 */
class ConvertGuest implements ObserverInterface
{
    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;
    /**
     * @var EncryptorInterface
     */
    protected $_encryptor;
    /**
     * @var OrderCustomerManagementInterface
     */
    protected $orderCustomerService;
    /**
     * @var OrderFactory
     */
    protected $_orderFactory;
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @var CustomerFactory
     */
    protected $_customer;

    /**
     * @param StoreManagerInterface $storeManager
     * @param OrderCustomerManagementInterface $orderCustomerService
     * @param OrderFactory $orderFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param CustomerFactory $customer
     * @param EncryptorInterface $encryptor
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        StoreManagerInterface            $storeManager,
        OrderCustomerManagementInterface $orderCustomerService,
        OrderFactory                     $orderFactory,
        OrderRepositoryInterface         $orderRepository,
        CustomerFactory                  $customer,
        EncryptorInterface               $encryptor,
        CollectionFactory                $collectionFactory
    )
    {
        $this->_collectionFactory = $collectionFactory;
        $this->_encryptor = $encryptor;
        $this->_storeManager = $storeManager;
        $this->orderCustomerService = $orderCustomerService;
        $this->_orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
        $this->_customer = $customer;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws AlreadyExistsException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        //take the last order
        $orderId = $orderIds[0];
        $order = $this->_orderFactory->create()->load($orderId);
        $customer = $this->_customer->create();

        //Base on order detail to approach customer
        $customer->setWebsiteId($this->_storeManager->getStore()->getWebsiteId());
        $customer->loadByEmail($order->getCustomerEmail());

        //Convert guest into customer
        if ($order->getId() && !$customer->getId()) {

            $registration = $this->orderCustomerService->create($orderId);
            $new_one = $this->_customer->create()->load( $registration->getId());
            $new_one->setPassword('mort123');
            $new_one->save();
        } else {
            //if customer Registered and checkout as guest
            $order->setCustomerId($customer->getId());
            $order->setCustomerIsGuest(0);
            $this->orderRepository->save($order);
        }
    }
}