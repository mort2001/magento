<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Tigren\Question\Model\ResourceModel\Post\CollectionFactory;

class Create extends Template
{
    protected $collection;
    /**
     * @param Context $context
     */
    public function __construct(Context $context, CollectionFactory $collectionFactory)
    {
        $this->collection = $collectionFactory;
        parent::__construct($context);
    }

    public function getCollection()
    {
        return $this->collection->create();
    }
}