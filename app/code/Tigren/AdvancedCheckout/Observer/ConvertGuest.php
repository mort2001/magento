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
use Tigren\CustomerGroupCatalog\Model\HistoryFactory;
use Tigren\CustomerGroupCatalog\Helper\Data;
use Zend_Log_Exception;
use Magento\Customer\Model\Session;

/**
 * Class ConvertGuest
 * @package Tigren\AdvancedCheckout\Observer
 */
class ConvertGuest implements ObserverInterface
{
    protected $_session;
    /**
     * @var Data
     */
    protected $_helper;
    /**
     * @var HistoryFactory
     */
    protected $_historyFactory;
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
     * @param HistoryFactory $historyFactory
     * @param Data $helper
     */
    public function __construct(
        StoreManagerInterface            $storeManager,
        OrderCustomerManagementInterface $orderCustomerService,
        OrderFactory                     $orderFactory,
        OrderRepositoryInterface         $orderRepository,
        CustomerFactory                  $customer,
        EncryptorInterface               $encryptor,
        CollectionFactory                $collectionFactory,
        HistoryFactory                   $historyFactory,
        Data                             $helper,
        Session $session
    )
    {
        $this->_session = $session;
        $this->_helper = $helper;
        $this->_historyFactory = $historyFactory;
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
     * @throws Zend_Log_Exception
     */
    public function execute(Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        //take the last order
        $orderId = $orderIds[0];
        $order = $this->_orderFactory->create()->load($orderId);
        //Call History Model
        $history = $this->_historyFactory->create();
        //Get Rule_ID
        $rule = $this->_helper->getRuleId();

        //Nếu customer dãd đăng nhập và lấy đc orderId
        if($this->_session->isLoggedIn() && $order->getId())
        {
            $customerId = $this->_session->getCustomerId();
            $order->setCustomerId($customerId);
            $order->setCustomerIsGuest(0);
            $this->orderRepository->save($order);

            $arr = [
                'order_id' => $order->getId(),
                'customer_id' => $customerId,
                'rule_id' => $rule
            ];
        }else{
            $registration = $this->orderCustomerService->create($orderId);
            $new_one = $this->_customer->create()->load($registration->getId());
            $new_one->setPassword('mort123');
            $new_one->save();

            $arr = [
                'order_id' => $order->getId(),
                'customer_id' => $registration->getId(),
                'rule_id' => ''
            ];
        }

        $history->addData($arr);
        $history->save();
    }
}