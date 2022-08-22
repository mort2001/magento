<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Reindex\Block\Adminhtml;

class Buttons extends \Magento\Backend\Block\Widget\Container
{
    public function _construct()
    {
        $this->buttonList->add(
            'amreindex',
            [
                'class' => 'primary',
                'label' => __('Reindex All'),
                'on_click' => 'location.href="' . $this->_urlBuilder->getUrl('amreindex/reindex') . '";'
            ],
            10
        );

        parent::_construct();
    }
}
