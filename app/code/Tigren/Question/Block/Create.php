<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Tigren\Question\Model\ResourceModel\Post\Collection;
use Tigren\Question\Model\ResourceModel\Post\CollectionFactory;

/**
 * Class Create
 * @package Tigren\Question\Block
 */
class Create extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @param Context $context
     */
    public function __construct(Context $context, CollectionFactory $collectionFactory)
    {
        $this->collection = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collection->create();
    }
}