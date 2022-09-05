<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\Collection;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;
use Magento\Customer\Model\Session;

/**
 * Class Data
 * @package Tigren\CustomerGroupCatalog\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var Session
     */
    protected $_session;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param Session $session
     */
    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        Session           $session
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->_session = $session;
        parent::__construct($context);
    }

    /**
     * @return Collection
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getRules()
    {
        $group_id = $this->_session->getCustomerGroupId();
        $ruleCollection = $this->collectionFactory->create()->addFieldToFilter('customer_group_ids', $group_id);
        $priority = $ruleCollection->getColumnValues('priority');

        return $this->collectionFactory->create()->addFieldToFilter('priority', min($priority));
    }

    /**
     * @return float|int|void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getDiscount()
    {
        if ($this->_session->isLoggedIn()) {
            $group_id = $this->_session->getCustomerGroupId();
            $ruleCollection = $this->collectionFactory->create()->addFieldToFilter('customer_group_ids', $group_id);
            $priority = $ruleCollection->getColumnValues('priority');
            $priority_collection = $this->collectionFactory->create()
                ->addFieldToFilter('priority', min($priority))
                ->addFieldToFilter('from_date', ['lt' => date('Y-m-d')])
                ->addFieldToFilter('to_date', ['gt' => date('Y-m-d')]);
            $discount = $priority_collection->getColumnValues('discount_amount');
            $integerIDs = array_map('intval', $discount);
            $percent = 0;
            foreach ($integerIDs as $percent) {
                $percent = $percent / 100;
            }

            return $percent;
        }
    }
}
