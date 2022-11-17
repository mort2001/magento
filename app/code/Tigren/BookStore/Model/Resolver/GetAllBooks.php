<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\BookStore\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Tigren\BookStore\Model\ResourceModel\Book\CollectionFactory;

/**
 * Class GetAllBooks
 * @package Tigren\BookStore\Model\Resolver
 */
class GetAllBooks implements ResolverInterface
{
    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed|null
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $allData = [];
        $bookCollection = $this->_collectionFactory->create()->getData();
        foreach ($bookCollection as $value){
            //Cach 1:
//            $author = ["author" => array_slice($value,4)];
//            $result = array_merge($value, $author);
//            $allData[] = $result;

            //Cach 2:
            $sliceItems = [
                'author_id' => $value['author_id'],
                'name' => $value['name'],
                'age' => $value['age'],
                'gender' => $value['gender']
            ];
            unset($value['name'], $value['age'], $value['gender'], $value['author_id']);
            $newArrayAllBooks = array_merge($value, ["author" => $sliceItems]);
            $allData[] = $newArrayAllBooks;
        }

        return $allData;
    }
}