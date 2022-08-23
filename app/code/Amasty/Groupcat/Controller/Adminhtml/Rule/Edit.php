<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Controller\Adminhtml\Rule;

use Amasty\Groupcat\Controller\RegistryConstants;
use Magento\CatalogRule\Model\Rule;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends \Amasty\Groupcat\Controller\Adminhtml\Rule
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->ruleRepository->get($id);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This rule no longer exists.'));

                return $this->resultRedirectFactory->create()->setPath('amasty_groupcat/*');
            }
        } else {
            /** @var Rule $model */
            $model = $this->ruleFactory->create();
        }

        // set entered data if was error when we do save
        $data = $this->_session->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $this->coreRegistry->register(RegistryConstants::CURRENT_GROUPCAT_RULE_ID, $model);
        $resultPage = $this->_initAction();

        // set title and breadcrumbs
        $breadcrumb = $id ? __('Edit Customer Group Catalog Rule') : __('New Customer Group Catalog Rule');
        $resultPage->addBreadcrumb($breadcrumb, $breadcrumb);
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Customer Group Catalog Rule'));
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getRuleId() ? $model->getName() : __('New Customer Group Catalog Rule')
        );

        return $resultPage;
    }
}