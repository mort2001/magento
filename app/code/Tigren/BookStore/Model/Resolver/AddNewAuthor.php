<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\BookStore\Model\Resolver;

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Tigren\BookStore\Model\ResourceModel\Book as Resource;

/**
 * Class AddNewAuthor
 * @package Tigren\BookStore\Model\Resolver
 */
class AddNewAuthor implements ResolverInterface
{
    private $_resource;

    public function __construct(Resource $resource)
    {
        $this->_resource = $resource;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return Value|mixed
     * @throws Exception
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $connection = $this->_resource->getConnection();
        $authorTable = $connection->getTableName('tigren_book_store_author');

        if ($args['input']) {
            $checkBeforeSaveAuthor = $connection->select()->from($authorTable, ['*'])
                ->where('pseudonym =?', $args['input']['pseudonym'])
                ->limit(1);
            $author = $connection->fetchRow($checkBeforeSaveAuthor);
            if ($author) {
                throw new Exception (__("This pseudonym had already!!! Please try some other"));
            }
            $connection->insert($authorTable, $args['input']);
            $lastAuthor = $connection->select()->from($authorTable, ['*'])
                ->order('author_id DESC')
                ->limit(1);
            return array_merge($connection->fetchRow($lastAuthor), ['message' => 'Add author successfully']);
        }
        return false;
    }
}