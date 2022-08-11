<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Tigren\Question\Model\PostFactory;

/**
 *
 */
class Index extends Action
{
    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @param Context $context
     * @param PostFactory $postFactory
     */
    public function __construct(
        Context     $context,
        PostFactory $postFactory
    )
    {
        $this->postFactory = $postFactory;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $data = $this->postFactory->create()->getCollection();
        foreach ($data as $value) {
            echo "<pre>";
            print_r($value->getData());
            echo "</pre>";
        }
    }
}