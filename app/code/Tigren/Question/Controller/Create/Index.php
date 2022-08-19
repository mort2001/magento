<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Controller\Create;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $_pageFactory;
    protected $_sesstion;

    public function __construct(
        Context     $context,
        PageFactory $pageFactory,
        Session     $session
    )
    {
        $this->_sesstion = $session;
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        if ($this->_sesstion->isLoggedIn()) {
            return $this->_pageFactory->create();
        } else {
            return $this->_redirect('customer/account/login');
        }
    }
}
