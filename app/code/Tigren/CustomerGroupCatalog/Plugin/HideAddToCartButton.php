<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Plugin;

use Closure;
use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Session;

/**
 * Class HideButton
 * @package Tigren\CustomerGroupCatalog\Plugin
 */
class HideAddToCartButton
{
    /**
     * @var Session
     */
    protected $sesstion;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->sesstion = $session;
    }

    /**
     * @param Product $product
     * @param $result
     * @return bool|void
     */
    public function afterIsSalable(Product $product, $result)
    {
        if ($this->sesstion->isLoggedIn()) {
            return $result;
        }
    }
//
//    /**
//     * @param Product $product
//     * @param Closure $result
//     * @return bool|void
//     */
//    public function aroundIsSalable(Product $product, Closure $result)
//    {
//        if ($this->sesstion->isLoggedIn()) {
//            return true;
//        }
//    }


}