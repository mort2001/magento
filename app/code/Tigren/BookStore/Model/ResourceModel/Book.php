<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\BookStore\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Book
 * @package Tigren\BookStore\Model\ResourceModel
 */
class Book extends AbstractDb {
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('tigren_book_store','entity_id');
    }
}