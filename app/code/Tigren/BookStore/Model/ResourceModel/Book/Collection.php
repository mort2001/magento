<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\BookStore\Model\ResourceModel\Book;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Tigren\BookStore\Model\ResourceModel\Book
 */
class Collection extends AbstractCollection
{
    /**
     * @var
     */
    protected $_tableAuthor;

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Tigren\BookStore\Model\Book', 'Tigren\BookStore\Model\ResourceModel\Book');
        $this->_tableAuthor = $this->getTable('tigren_book_store_author');
    }

    /**
     * @return Collection|void
     */
    public function _initSelect()
    {$this->getSelect()->from(['main_table' => $this->getMainTable()], ['*'])
            ->joinLeft(['author' => $this->_tableAuthor], 'main_table.author_id = author.author_id', ['author.name', 'author.age', 'author.gender']);
    }
}