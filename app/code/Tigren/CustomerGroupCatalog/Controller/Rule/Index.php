<?php

namespace Tigren\CustomerGroupCatalog\Controller\Rule;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;

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
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Session $session
     */
    public function __construct(Context $context, PageFactory $pageFactory,Session $session)
    {
        $this->_session = $session;
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|null
     */
    public function execute()
    {
        if($this->_session->isLoggedIn()) {
            return $this->_pageFactory->create();
        } else {
            $this->messageManager->addErrorMessage('PLs Login first');
            $this->_redirect('customer/account/login');
        }

    }
}