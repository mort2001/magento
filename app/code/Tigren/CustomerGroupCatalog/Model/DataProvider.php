<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;

/**
 * Class DataProvider
 * @package Emipro\Custom\Model
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $CollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $CollectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $CollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $Rule) {
            $this->loadedData[$Rule->getId()] = $Rule->getData();
        }

        return $this->loadedData;
    }
}
