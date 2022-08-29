<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Reindex from Admin for Magento 2
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
