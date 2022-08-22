<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Reindex\Controller\Adminhtml\Reindex;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Indexer\Model\Indexer\CollectionFactory;

class Status extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Magento_Indexer::index';

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var TimezoneInterface
     */
    private $timezone;

    public function __construct(
        CollectionFactory $collectionFactory,
        TimezoneInterface $timezone,
        Action\Context $context
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->timezone = $timezone;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = [];
        foreach ($this->collectionFactory->create()->getItems() as $item) {
            $result[$item->getId()] = [
                'status' => $item->getStatus(),
                'updated_at' => empty($item->getLatestUpdated()) ? __('Never') : $this->timezone->formatDateTime(
                    $item->getLatestUpdated(),
                    \IntlDateFormatter::MEDIUM,
                    \IntlDateFormatter::MEDIUM,
                    null,
                    null
                )
            ];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
