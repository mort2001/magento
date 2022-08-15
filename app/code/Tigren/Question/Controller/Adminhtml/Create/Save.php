<?php

namespace Tigren\Question\Controller\Adminhtml\Create;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
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

    /**
     * @param Context $context
     * @param PostFactory $mcfFactory
     */
    public function __construct(Context $context, PostFactory $mcfFactory,)
    {
        $this->_mcfFactory = $mcfFactory;
        parent::__construct($context);
    }

    /**
     * @return void
     */
    public function execute()
    {
        die('asdsad');
        $data = $this->getRequest()->getParams();
        var_dump($data);
        die;
        $model_data = $this->_mcfFactory->create();
        $model_data->addData($data);
        $model_data->save();
        $this->messageManager->addSuccessMessage("Saved Data");
    }
}