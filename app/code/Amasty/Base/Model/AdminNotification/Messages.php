<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Amasty\Base\Model\AdminNotification;

class Messages
{
    public const AMBASE_SESSION_IDENTIFIER = 'ambase-session-messages';

    /**
     * @var \Magento\Backend\Model\Session
     */
    private $session;

    public function __construct(
        \Magento\Backend\Model\Session $session
    ) {
        $this->session = $session;
    }

    /**
     * @param string $message
     */
    public function addMessage($message)
    {
        $messages = $this->session->getData(self::AMBASE_SESSION_IDENTIFIER);
        if (!$messages || !is_array($messages)) {
            $messages = [];
        }

        $messages[] = $message;
        $this->session->setData(self::AMBASE_SESSION_IDENTIFIER, $messages);
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        $messages = $this->session->getData(self::AMBASE_SESSION_IDENTIFIER);
        $this->clear();
        if (!$messages || !is_array($messages)) {
            $messages = [];
        }

        return $messages;
    }

    public function clear()
    {
        $this->session->setData(self::AMBASE_SESSION_IDENTIFIER, []);
    }
}
