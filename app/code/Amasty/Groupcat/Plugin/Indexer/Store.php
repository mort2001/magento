<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Customer Group Catalog for Magento 2
*/

namespace Amasty\Groupcat\Plugin\Indexer;

use Amasty\Groupcat\Model\Indexer\Rule\RuleProductProcessor;

class Store extends \Magento\CatalogRule\Plugin\Indexer\Website
{
    /**
     * override constructor. Indexer is changed
     *
     * @param RuleProductProcessor $ruleProductProcessor
     */
    public function __construct(RuleProductProcessor $ruleProductProcessor)
    {
        $this->ruleProductProcessor = $ruleProductProcessor;
    }
}
