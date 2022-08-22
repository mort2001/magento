<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Model\ResourceModel;

use Amasty\Groupcat\Model\ResourceModel\Rule;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\AttributeInterface;

class ReadHandler implements AttributeInterface
{
    /**
     * @var Rule
     */
    protected $ruleResource;

    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    public function __construct(
        Rule $ruleResource,
        MetadataPool $metadataPool
    ) {
        $this->ruleResource = $ruleResource;
        $this->metadataPool = $metadataPool;
    }

    /**
     * @param string $entityType
     * @param array  $entityData
     * @param array  $arguments
     *
     * @return array
     * @throws \Exception
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute($entityType, $entityData, $arguments = [])
    {
        $linkField = $this->metadataPool->getMetadata($entityType)->getLinkField();
        $entityId  = $entityData[$linkField];

        $entityData['customer_group_ids'] = $this->ruleResource->getCustomerGroupIds($entityId);
        $entityData['category_ids']       = $this->ruleResource->getCategoryIds($entityId);
        $entityData['store_ids']          = $this->ruleResource->getStoreIds($entityId);

        return $entityData;
    }
}
