<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Groupcat\Api;

/**
 * @api
 */
interface RequestRepositoryInterface
{
    /**
     * @param \Amasty\Groupcat\Api\Data\RequestInterface $request
     * @return \Amasty\Groupcat\Api\Data\RequestInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Amasty\Groupcat\Api\Data\RequestInterface $request);

    /**
     * @param int $requestId
     * @return \Amasty\Groupcat\Api\Data\RequestInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($requestId);

    /**
     * @param \Amasty\Groupcat\Api\Data\RequestInterface $request
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Amasty\Groupcat\Api\Data\RequestInterface $request);

    /**
     * @param int $requestId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($requestId);
}
