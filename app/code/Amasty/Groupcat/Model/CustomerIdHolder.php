<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Model;

/**
 * Singleton for fix get customer id from session with cache fix
 * @see \Magento\Customer\Model\Layout\DepersonalizePlugin::afterGenerateXml
 * @since 1.4.3
 */
class CustomerIdHolder
{
    /**
     * @var int
     */
    private $customerId;

    /**
     * @var bool
     */
    private $isSetUsed = false;

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     *
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = (int)$customerId;
        $this->isSetUsed = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIdInitialized()
    {
        return $this->isSetUsed;
    }
}
