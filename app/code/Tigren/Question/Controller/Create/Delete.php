<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Controller\Create;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Tigren\Question\Model\PostFactory;
use Tigren\Question\Model\ResourceModel\Post\CollectionFactory;

/**
 * @package Class Index of Tigren\Customer\Controller\Question
 */
class Delete extends Action
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param PageFactory $_pageFactory
     */
    public function __construct(
        Context           $context,
        PageFactory       $_pageFactory,
        PostFactory       $postFactory,
        CollectionFactory $collectionFactory
    )
    {
        $this->_pageFactory = $_pageFactory;
        $this->postFactory = $postFactory;
        $this->collectionFactory = $collectionFactory;
        return parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParams()['id'];
        $post = $this->postFactory->create()->load($id);

        if ($post->getData('entity_id')) {
            $post->delete();
            $this->messageManager->addSuccess('Delete Success');
        } else {
            $this->messageManager->addError('Error');
        }
        return $this->resultRedirectFactory->create()->setPath('question/create/listquestion');
    }
}