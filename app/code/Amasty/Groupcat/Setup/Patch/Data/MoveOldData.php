<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
declare(strict_types=1);

namespace Amasty\Groupcat\Setup\Patch\Data;

use Amasty\Groupcat\Setup\Operation\UpgradeTo120;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Module\ResourceInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class MoveOldData implements DataPatchInterface
{
    /**
     * @var ResourceInterface
     */
    private $moduleResource;

    /**
     * @var State
     */
    private $appState;

    /**
     * @var UpgradeTo120
     */
    private $upgradeTo120;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    public function __construct(
        ResourceInterface $moduleResource,
        State $appState,
        UpgradeTo120 $upgradeTo120,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleResource = $moduleResource;
        $this->appState = $appState;
        $this->upgradeTo120 = $upgradeTo120;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $setupDataVersion = $this->moduleResource->getDataVersion('Amasty_Groupcat');

        if ($setupDataVersion && version_compare($setupDataVersion, '1.2.0', '<')) {
            $this->appState->emulateAreaCode(
                Area::AREA_ADMINHTML,
                [$this->upgradeTo120, 'execute'],
                [$this->moduleDataSetup]
            );
        }
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
