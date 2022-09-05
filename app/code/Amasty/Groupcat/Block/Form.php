<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Customer Group Catalog for Magento 2
*/

declare(strict_types=1);

namespace Amasty\Groupcat\Block;

use Amasty\Groupcat\Helper\Data as Config;
use Magento\Framework\View\Element\Template;

class Form extends Template
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Template\Context $context,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getGDPRText(): string
    {
        return $this->filterManager->stripTags(
            $this->getConfig()->getModuleConfig('gdpr/text'),
            [
                'allowableTags' => '<a>',
                'escape' => false
            ]
        );
    }
}
