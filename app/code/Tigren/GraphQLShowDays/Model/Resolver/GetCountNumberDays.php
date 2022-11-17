<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GraphQLShowDays\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Class GetCountNumberDays
 * @package Tigren\GraphQL\Model\Resolver
 */
class GetCountNumberDays implements ResolverInterface
{
    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return \Magento\Framework\GraphQl\Query\Resolver\Value|mixed|void
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($args['input']['month']) || !isset($args['input']['year'])) {
            throw new GraphQlInputException(__('Month or Year not indicated'));
        }
        return [
            'days' => cal_days_in_month(CAL_GREGORIAN, $args['input']['month'], $args['input']['year'])
        ];
    }
}