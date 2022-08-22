<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\GroupAssign\Plugin\Customer\Model\ResourceModel\GroupRepository\Adminhtml;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Api\Data\GroupInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Customer\Api\Data\GroupExtensionInterfaceFactory;

class SetExtensionAttributes
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var GroupExtensionInterfaceFactory
     */
    private $groupExtensionInterfaceFactory;

    public function __construct(
        RequestInterface $request,
        GroupExtensionInterfaceFactory $groupExtensionInterfaceFactory
    ) {
        $this->request = $request;
        $this->groupExtensionInterfaceFactory = $groupExtensionInterfaceFactory;
    }

    public function beforeSave(
        GroupRepositoryInterface $groupRepository,
        GroupInterface $customerGroup
    ) {
        if ($this->request->isPost()) {
            $extensionAttributes = $customerGroup->getExtensionAttributes()
                ? $customerGroup->getExtensionAttributes()
                : $this->groupExtensionInterfaceFactory->create();

            $isVisibleOnStorefront = (bool)$this->request->getParam('is_visible_on_storefront');
            $extensionAttributes->setIsVisibleOnStorefront($isVisibleOnStorefront);
            $customerGroup->setExtensionAttributes($extensionAttributes);
        }
    }
}
