<?php

namespace Tigren\Question\Controller\Create;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;

class ListQuestion extends Action
{
    protected $resultPageFactory;
    protected $_sesstion;

    public function __construct(Context $context, PageFactory $resultPageFactory, Session $session)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_sesstion = $session;
    }

    public function execute()
    {
        if ($this->_sesstion->isLoggedIn()) {
            return $this->resultPageFactory->create();
        } else {
            return $this->_redirect('customer/account/login');
        }
    }
}