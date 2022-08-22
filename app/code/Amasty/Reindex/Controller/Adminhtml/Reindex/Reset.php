<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Reindex\Controller\Adminhtml\Reindex;

class Reset extends MassReset
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($indexerId = $this->getRequest()->getParam('indexer_id')) {
            $this->getRequest()->setParams(['indexer_ids' => [$indexerId]]);

            return parent::execute();
        }

        return $this->resultRedirectFactory->create()->setRefererUrl();
    }
}
