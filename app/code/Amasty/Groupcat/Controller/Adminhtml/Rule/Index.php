<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Controller\Adminhtml\Rule;

class Index extends \Amasty\Groupcat\Controller\Adminhtml\Rule
{
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Amasty Customer Group Catalog Rules'));

        return $resultPage;
    }
}