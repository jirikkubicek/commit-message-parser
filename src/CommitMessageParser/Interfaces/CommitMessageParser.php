<?php

namespace CommitMessageParser\Interfaces;

interface CommitMessageParser
{
    /**
     * @param string $message
     * @return CommitMessage
     */
    public function parse(string $message): CommitMessage;
}
