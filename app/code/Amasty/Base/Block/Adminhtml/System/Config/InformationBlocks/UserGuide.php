<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
declare(strict_types=1);

namespace Amasty\Base\Block\Adminhtml\System\Config\InformationBlocks;

use Amasty\Base\Block\Adminhtml\System\Config\Information;
use Amasty\Base\Model\Feed\ExtensionsProvider;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Element\Template;

class UserGuide extends Template
{
    public const USER_GUIDE_PARAM = 'userguide_';

    /**
     * @var string
     */
    protected $_template = 'Amasty_Base::config/information/user_guide.phtml';

    /**
     * @var ExtensionsProvider
     */
    private $extensionsProvider;

    public function __construct(
        Template\Context $context,
        ExtensionsProvider $extensionsProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->extensionsProvider = $extensionsProvider;
    }

    public function getUserGuideLink(): string
    {
        $moduleCode = $this->getElement()->getDataByPath('group/module_code');

        $link = $this->extensionsProvider->getFeedModuleData($moduleCode)['guide'] ?? '';
        if ($link) {
            $seoLink = str_replace('?', '&', Information::SEO_PARAMS);
            $link .= $seoLink . self::USER_GUIDE_PARAM . $moduleCode;
        }

        return $link;
    }

    public function getElement(): AbstractElement
    {
        return $this->getParentBlock()->getElement();
    }
}