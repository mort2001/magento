<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Plugin\Framework\App\Http;

use Amasty\Groupcat\Helper\Data;
use Amasty\Groupcat\Model\ProductRuleProvider;
use Amasty\Groupcat\Model\Rule;
use Magento\Framework\App\Http\Context as HttpContext;

class Context
{
    /**
     * @var ProductRuleProvider
     */
    private $ruleProvider;

    /**
     * @var Data
     */
    private $helper;

    public function __construct(
        Data $helper,
        ProductRuleProvider $ruleProvider
    ) {
        $this->ruleProvider = $ruleProvider;
        $this->helper = $helper;
    }

    /**
     * @param HttpContext $subject
     */
    public function beforeGetVaryString(HttpContext $subject)
    {
        if (!$this->helper->isModuleEnabled()) {
            return;
        }

        $subject->setValue(
            Rule::CACHE_TAG,
            implode('_', $this->ruleProvider->getActiveRulesCollection()->getAllIds()),
            ''
        );
    }
}
