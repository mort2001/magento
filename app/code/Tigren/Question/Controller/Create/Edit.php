<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Controller\Create;

use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Tigren\Question\Model\PostFactory;

/**
 *
 */
class Edit extends Action
{
    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @param PostFactory $postFactory
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        PostFactory $postFactory,
        Context     $context,
        PageFactory $pageFactory
    )
    {
        $this->postFactory = $postFactory;
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * @return Page|ResultInterface
     * @throws Exception
     */
    public function execute()
    {
        return $this->pageFactory->create();
    }


}