<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Plugin\Magento\Catalog\Model;

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
    protected $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param Product $product
     * @param $result
     * @return bool|void
     */
    public function afterIsSalable(Product $product, $result)
    {
        if ($this->session->isLoggedIn()) {
            return $result;
        }
    }
}