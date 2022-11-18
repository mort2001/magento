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
use Magento\Reports\Model\ResourceModel\Product\Index\Viewed as IndexResource;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class AddViewCount implements ResolverInterface
{
    private $_resource;

    private $_collectionFactory;

    public function __construct
    (
        IndexResource     $resource,
        CollectionFactory $collectionFactory
    )
    {
        $this->_resource = $resource;
        $this->_collectionFactory = $collectionFactory;
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
        if ($args['sku']) {
            $productCollection = $this->_collectionFactory->create()
                ->addFieldToFilter('sku', $args['sku'])
                ->getColumnValues('entity_id');
            if ($productCollection) {
                $connection = $this->_resource->getConnection();
                $indexViewTable = $connection->getTableName('report_viewed_product_index');


                $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
                $logger = new \Zend_Log();
                $logger->addWriter($writer);
                $logger->info(print_r($productCollection, true));
                $logger->info(print_r($context->getUserId(), true));

                if ($context->getUserId() !== 0) {
                    $connection->insert($indexViewTable, ['product_id' => $productCollection[0], 'customer_id' => $context->getUserId()]);
                }

                $connection->insert($indexViewTable, ['product_id' => $productCollection[0]]);
                return ['message' => "Add new view count for product successfully!!!"];
            } else {
                throw new Exception (__("There's no such product with sku: {$args['sku']}"));
            }
        }
        throw new Exception (__("Your input is invalid. Please try again'"));
    }
}