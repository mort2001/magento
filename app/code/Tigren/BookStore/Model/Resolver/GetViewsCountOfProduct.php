<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\BookStore\Model\Resolver;

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Reports\Model\ResourceModel\Report\Product\Viewed;
use Magento\Reports\Model\ResourceModel\Product\Index\Viewed as IndexResource;
use Magento\Reports\Model\ResourceModel\Report\Product\Viewed\CollectionFactory as DailyCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as Products;

/**
 * Class GetViewsCountOfProduct
 * @package Tigren\BookStore\Model\Resolver
 */
class GetViewsCountOfProduct implements ResolverInterface
{
    /**
     * @var Viewed
     */
    private $_resourceDaily;

    /**
     * @var DailyCollectionFactory
     */
    private $_dailyCollectionFactory;

    /**
     * @var Products
     */
    private $_products;

    /**
     * @var IndexResource
     */
    private $_resourceIndex;

    /**
     * @param Viewed $resource
     * @param DailyCollectionFactory $dailyCollectionFactory
     * @param Products $products
     * @param IndexResource $resourceIndex
     */
    public function __construct(Viewed $resource, DailyCollectionFactory $dailyCollectionFactory, Products $products, IndexResource $resourceIndex)
    {
        $this->_resourceDaily = $resource;
        $this->_resourceIndex = $resourceIndex;
        $this->_dailyCollectionFactory = $dailyCollectionFactory;
        $this->_products = $products;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|false
     * @throws Exception
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if ($args['sku']) {
            $productCollection = $this->_products->create()
                ->addFieldToFilter('sku', $args['sku'])
                ->getColumnValues('entity_id');
            if ($productCollection) {
                //Base on Daily
//                $connection = $this->_resource->getConnection();
//                $reportDailyTable = $connection->getTableName('report_viewed_product_aggregated_daily');
//
//                $select = $connection->select()->from($reportDailyTable, 'views_num')
//                    ->where('product_id =?', $productCollection[0])
//                    ->limit(1);
//                $viewsCount = $connection->fetchRow($select);

                //Base on all timeline
                $connection = $this->_resourceIndex->getConnection();
                $reportIndexTable = $connection->getTableName('report_viewed_product_index');

                $select = $connection->select()->from($reportIndexTable, ['*'])
                    ->where('product_id =?', $productCollection[0]);
                $viewsCount = count($connection->fetchAll($select));

                return array_merge(['views_count' => $viewsCount], ['message' => "This product has the number of view: {$viewsCount}"]);
            } else {
                throw new Exception (__("There is no product with sku '{$args['sku']}'"));
            }

        }
        return false;
    }
}