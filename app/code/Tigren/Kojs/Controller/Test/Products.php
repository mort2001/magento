<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Kojs\Controller\Test;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Store\Model\StoreManager;

/**
 * Class Index
 * @package Tigren\Kojs\Controller\Test
 */
class Products extends Action
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;
    /**
     * @var Image
     */
    protected $imageHelper;
    /**
     * @var
     */
    protected $listProduct;
    /**
     * @var StoreManager
     */
    protected $_storeManager;

    /**
     * @param Context $context
     * @param FormKey $formKey
     * @param ProductFactory $productFactory
     * @param StoreManager $storeManager
     * @param Image $imageHelper
     */
    public function __construct(
        Context $context,
        FormKey $formKey,
        ProductFactory $productFactory,
        StoreManager $storeManager,
        Image $imageHelper
    ) {
        $this->productFactory = $productFactory;
        $this->imageHelper = $imageHelper;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->productFactory->create()
            ->getCollection()
            ->addAttributeToSelect('*')
            ->setPageSize(5)
            ->setCurPage(1);
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $product = $this->productFactory->create()->load($id);

            $productData = [
                'entity_id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'src' => $this->imageHelper->init($product, 'product_base_image')->getUrl(),
            ];

            echo json_encode($productData);
        }
    }
}