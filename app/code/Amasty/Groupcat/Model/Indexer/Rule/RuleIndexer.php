<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Model\Indexer\Rule;

use Amasty\Groupcat\Model\Indexer\AbstractIndexer;

class RuleIndexer extends AbstractIndexer
{
    /**
     * @var \Amasty\Groupcat\Model\Indexer\Customer\IndexBuilder
     */
    protected $customerIndexBuilder;

    public function __construct(
        \Amasty\Groupcat\Model\Indexer\Product\IndexBuilder $productIndexBuilder,
        \Amasty\Groupcat\Model\Indexer\Customer\IndexBuilder $customerIndexBuilder,
        \Magento\Framework\Event\ManagerInterface $eventManager
    ) {
        parent::__construct($productIndexBuilder, $eventManager);
        $this->customerIndexBuilder = $customerIndexBuilder;
    }

    /**
     * {@inheritdoc}
     */
    protected function doExecuteList($ids)
    {
        $this->indexBuilder->reindexByIds($ids);
        $this->customerIndexBuilder->reindexByIds($ids);
        $this->getCacheContext()->registerTags($this->getIdentities());
    }

    /**
     * {@inheritdoc}
     */
    protected function doExecuteRow($id)
    {
        $this->indexBuilder->reindexById($id);
        $this->customerIndexBuilder->reindexById($id);
    }

    /**
     * {@inheritdoc}
     */
    public function executeFull()
    {
        $this->customerIndexBuilder->reindexFull();
        parent::executeFull();
    }
}
