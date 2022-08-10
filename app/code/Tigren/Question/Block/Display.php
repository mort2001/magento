<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;


class Display extends Template
{
    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function sayhi()
    {
        return __('Hello World!!!!');
    }
}