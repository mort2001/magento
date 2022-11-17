<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\BookStore\Model\Resolver;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use PHPUnit\Util\Exception;
use Tigren\BookStore\Model\BookFactory;
use Tigren\BookStore\Model\ResourceModel\Book\CollectionFactory;
use Tigren\BookStore\Model\ResourceModel\Book;

/**
 * Class AddNewBook
 * @package Tigren\BookStore\Model\Resolver
 */
class AddNewBook implements ResolverInterface
{
    /**
     * @var BookFactory
     */
    private $_model;

    /**
     * @var Book
     */
    private $_resource;

    /**
     * @var CollectionFactory
     */
    private $_collectionFactory;

    /**
     * @param BookFactory $model
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(BookFactory $model, CollectionFactory $collectionFactory, Book $resource)
    {
        $this->_model = $model;
        $this->_resource = $resource;
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return int|Value|mixed|string
     * @throws AlreadyExistsException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $connection = $this->_resource->getConnection();
        $authorTable = $connection->getTableName('tigren_book_store_author');

        if (isset($args['input'])) {
            $model = $this->_model->create();
            $findAuthorByPseudonym = $connection->select()->from($authorTable, ['*'])
                ->where('pseudonym =?', $args['input']['author_pseudonym'])
                ->limit(1);
            $author = $connection->fetchRow($findAuthorByPseudonym);
            if ($author) {
                $data = [
                    'title' => $args['input']['title'],
                    'page' => $args['input']['page'],
                    'created_at' => $args['input']['created_at'],
                    'author_id' => $author['author_id']
                ];

                $model->addData($data);
                $this->_resource->save($model);
                $lastBook = $this->_collectionFactory->create()->setOrder('entity_id', 'DESC')->setPageSize(1)->getFirstItem()->getData();

                return array_merge($lastBook, ['author' => $author], ['message' => "Add successfully!!!"]);
            } else {
                throw new Exception(__("There's no author with pseudonym '{$args['input']['author_pseudonym']}'"));
            }
        }
        return '';
    }
}