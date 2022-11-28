<?php

namespace Tigren\Kojs\Controller\Test;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $_resultFactory;

    public function __construct(Context $context, PageFactory $resultFactory)
    {
        $this->_resultFactory = $resultFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        return $this->_resultFactory->create();
    }
}