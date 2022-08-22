<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
declare(strict_types=1);

namespace Amasty\Base\Utils;

use Magento\Framework\Api\SimpleDataObjectConverter;

class DataConverter
{
    /**
     * Converts associative array's key names from camelCase to snake_case, recursively.
     *
     * @param array $properties
     * @return array
     */
    public function convertArrayToSnakeCase(array $properties): array
    {
        foreach ($properties as $name => $value) {
            $snakeCaseName = SimpleDataObjectConverter::camelCaseToSnakeCase($name);
            if (is_array($value)) {
                $value = $this->convertArrayToSnakeCase($value);
            }
            unset($properties[$name]);
            $properties[$snakeCaseName] = $value;
        }

        return $properties;
    }
}
