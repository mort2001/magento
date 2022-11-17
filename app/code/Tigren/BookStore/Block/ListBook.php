<?php

namespace Tigren\BookStore\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Tigren\BookStore\Model\ResourceModel\Book\CollectionFactory;

class ListBook extends Template
{
    private $_collectionFactory;

    public function __construct(Context $context, CollectionFactory $collectionFactory)
    {
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function getAllBooks()
    {
        return $this->_collectionFactory->create()->getItems();
    }
}