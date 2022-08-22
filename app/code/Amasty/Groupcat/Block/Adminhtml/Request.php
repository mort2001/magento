<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Block\Adminhtml;

class Request extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller     = 'request';
        $this->_headerText     = __('Get a Quote Requests');
        parent::_construct();
    }

    protected function _addNewButton()
    {
        return;//remove new button
    }
}
