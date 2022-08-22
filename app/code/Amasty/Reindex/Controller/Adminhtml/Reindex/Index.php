<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Reindex\Controller\Adminhtml\Reindex;

class Index extends \Amasty\Reindex\Controller\Adminhtml\AbstractReindex
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->run();
        return $this->resultRedirectFactory->create()->setRefererUrl();
    }
}
