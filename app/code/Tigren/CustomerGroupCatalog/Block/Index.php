<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Block;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template\Context;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;

/**
 * Class Rule
 * @package Tigren\CustomerGroupCatalog\Block
 */
class Index extends Template
{
    protected $collectionFactory;
    protected $_session;

    /**
     * @param Context $context
     * @param Session $session
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Template\Context $context, Session $session, CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
        $this->_session = $session;
        parent::__construct($context);
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getPros()
    {
        $group_id = $this->_session->getCustomerGroupId();
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_group_id', $group_id);
        return $collection;

    }
}