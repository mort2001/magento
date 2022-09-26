<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Observer;

use Exception;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderCustomerManagementInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\OrderFactory;
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
    /**
     * @var Session
     */
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
     * @param OrderCustomerManagementInterface $orderCustomerService
     * @param OrderFactory $orderFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param CustomerFactory $customer
     * @param CollectionFactory $collectionFactory
     * @param HistoryFactory $historyFactory
     * @param Data $helper
     * @param Session $session
     */
    public function __construct(
        OrderCustomerManagementInterface $orderCustomerService,
        OrderFactory                     $orderFactory,
        OrderRepositoryInterface         $orderRepository,
        CustomerFactory                  $customer,
        CollectionFactory                $collectionFactory,
        HistoryFactory                   $historyFactory,
        Data                             $helper,
        Session                          $session
    )
    {
        $this->_session = $session;
        $this->_helper = $helper;
        $this->_historyFactory = $historyFactory;
        $this->_collectionFactory = $collectionFactory;
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
        $orderId = $orderIds[0];
        $lastOrder = $this->_orderFactory->create()->load($orderId);
        $historyCollection = $this->_historyFactory->create();
        $ruleId = $this->_helper->getRuleId();
        $isLogIn = $this->_session->isLoggedIn();

        if ($isLogIn && $lastOrder->getId()) {
            $customerId = $this->_session->getCustomerId();
            $lastOrder->setCustomerId($customerId);
            $lastOrder->setCustomerIsGuest(0);
            $this->orderRepository->save($lastOrder);

            $arr = [
                'order_id' => $lastOrder->getId(),
                'customer_id' => $customerId,
                'rule_id' => $ruleId
            ];
        } else if (!$isLogIn && $lastOrder->getId()) {
            $registration = $this->orderCustomerService->create($orderId);
            $new_customer = $this->_customer->create()->load($registration->getId());
            $new_customer->setPassword('mort123');
            $new_customer->save();

            $arr = [
                'order_id' => $lastOrder->getId(),
                'customer_id' => $registration->getId(),
                'rule_id' => $ruleId
            ];
        }

        $historyCollection->addData($arr);
        $historyCollection->save();
    }
}