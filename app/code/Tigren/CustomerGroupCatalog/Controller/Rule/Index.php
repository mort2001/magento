<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Controller\Rule;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;
use Tigren\CustomerGroupCatalog\Helper\Data;
use Zend_Log_Exception;

/**
 * Class Index
 * @package Tigren\CustomerGroupCatalog\Controller\Rule
 */
class Index extends Action
{
    /**
     * @var Session
     */
    protected $_session;

    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var Data
     */
    protected $_discount;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Session $session
     * @param Data $discount
     */
    public function __construct(
        Context     $context,
        PageFactory $pageFactory,
        Session     $session,
        Data        $discount
    )
    {
        $this->_discount = $discount;
        $this->_session = $session;
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page|void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @throws Zend_Log_Exception
     */
    public function execute()
    {
        if ($this->_session->isLoggedIn()) {
            $discount = $this->_discount->getDiscount();
            $this->messageManager->addSuccessMessage('Congratulation!!! You have received discount ' . $discount * 100 . '%' . ' all products!!!');

            return $this->_pageFactory->create();
        } else {
            $this->messageManager->addErrorMessage('Please Login first before doing anything ...');
            $this->_redirect('customer/account/login');
        }
    }
}