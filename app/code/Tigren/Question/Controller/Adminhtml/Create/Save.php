<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Controller\Adminhtml\Create;

use Magento\Customer\Model\Session;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Tigren\Question\Model\PostFactory;

/**
 *
 */
class Save extends Action
{
    /**
     * @var PostFactory
     */
    protected $_mcfFactory;
    protected $session;

    /**
     * @param Context $context
     * @param PostFactory $mcfFactory
     */
    public function __construct(Context $context, PostFactory $mcfFactory, Session $session)
    {
        $this->session = $session;
        $this->_mcfFactory = $mcfFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $model_data = $this->_mcfFactory->create();
        $authorId = $this->session->getCustomer()->getId();
        $data['author_id'] = $authorId;
        $model_data->addData($data);
        $model_data->save();
        $this->messageManager->addSuccessMessage("Saved Data");
        return $this->_redirect('question/create/index');
    }
}