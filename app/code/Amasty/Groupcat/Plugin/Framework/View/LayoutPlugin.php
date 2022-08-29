<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Customer Group Catalog for Magento 2
*/

namespace Amasty\Groupcat\Plugin\Framework\View;

/**
 * frontend layout plugin
 * @since 1.4.3
 */
class LayoutPlugin
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Amasty\Groupcat\Model\CustomerIdHolder
     */
    private $customerIdHolder;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Amasty\Groupcat\Model\CustomerIdHolder $customerIdHolder
    ) {
        $this->customerSession = $customerSession;
        $this->customerIdHolder = $customerIdHolder;
    }

    /**
     * Before generate Xml
     * get customer id from session before magento will clear it
     * @see \Magento\Customer\Model\Layout\DepersonalizePlugin::afterGenerateXml
     *
     * @param \Magento\Framework\View\LayoutInterface $subject
     * @return array
     */
    public function beforeGenerateXml(\Magento\Framework\View\LayoutInterface $subject)
    {
        if (!$this->customerIdHolder->isIdInitialized()) {
            $this->customerIdHolder->setCustomerId($this->customerSession->getCustomerId());
        }
        return [];
    }
}
