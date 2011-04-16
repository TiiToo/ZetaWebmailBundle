<?php
/*
 * Copyright 2011 SimpleThings GmbH
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace SimpleThings\ZetaWebmailBundle\Mailbox;

class ImapMailbox implements Mailbox
{
    /**
     * @var \ezcMailImapTransport
     */
    private $imapTransport;

    public function __construct(\ezcMailImapTransport $imapTransport)
    {
        $this->imapTransport = $imapTransport;
    }


    public function getMessage($messageId)
    {
        return $this->imapTransport->fetchByMessageNr($messageId);
    }

    public function getMessageList($offset = 0, $count = null)
    {
        return $this->imapTransport->fetchFromOffset($offset, $count);
    }

    public function hasFolders()
    {

    }

    /**
     * Get total count of the mailbox.
     *
     * @param string|integer
     * @param string|integer Mailbox identifier
     * @return int
     */
    public function getMessageCount()
    {
        $messageCount = $messageSize = 0;
        if (!$this->imapTransport->status($messageCount, $messageSize)) {
            throw MailboxException::sourceError();
        }
        return $messageCount;
    }
}