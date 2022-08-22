<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Controller\Adminhtml\Request;

use Amasty\Groupcat\Model\Source\Status;

class Edit extends \Amasty\Groupcat\Controller\Adminhtml\Request
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        try {
            $model = $this->requestRepository->get($id);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('This request no longer exists.'));

            return $this->resultRedirectFactory->create()->setPath('amasty_groupcat/*');
        }

        $this->coreRegistry->register(\Amasty\Groupcat\Controller\Adminhtml\Request::CURRENT_REQUEST_MODEL, $model);
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(
            __('Get a Quote Request from ') . $model->getName()
        );

        /* change request status to viewed*/
        if ($model->getStatus() == Status::PENDING) {
            $model->setStatus(Status::VIEWED);
            $this->requestRepository->save($model);
        }

        return $resultPage;
    }
}
