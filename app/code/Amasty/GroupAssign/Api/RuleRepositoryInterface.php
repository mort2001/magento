<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\GroupAssign\Api;

interface RuleRepositoryInterface
{
    /**
     * Save Rule
     *
     * @param \Amasty\GroupAssign\Api\Data\RuleInterface $rule
     *
     * @return \Amasty\GroupAssign\Api\Data\RuleInterface
     */
    public function save(\Amasty\GroupAssign\Api\Data\RuleInterface $rule);

    /**
     * Get rule by id
     *
     * @param int $ruleId
     *
     * @return \Amasty\GroupAssign\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($ruleId);

    /**
     * Delete Rule
     *
     * @param \Amasty\GroupAssign\Api\Data\RuleInterface $rule
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Amasty\GroupAssign\Api\Data\RuleInterface $rule);

    /**
     * Delete rule by id
     *
     * @param int $ruleId
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($ruleId);

    /**
     * Get all active rules
     *
     * @return \Amasty\GroupAssign\Api\Data\RuleInterface[]
     */
    public function getActiveRules();

    /**
     * Get rule by name
     *
     * @param string $ruleName
     *
     * @return \Amasty\GroupAssign\Api\Data\RuleInterface
     */
    public function getRuleByName($ruleName);
}
