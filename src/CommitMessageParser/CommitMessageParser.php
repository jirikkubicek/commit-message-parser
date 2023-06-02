<?php

namespace CommitMessageParser;

use CommitMessageParser\Interfaces\CommitMessageParser as CommitMessageParserInterface;

final class CommitMessageParser implements CommitMessageParserInterface
{
    /**
     * @param string $message
     * @return CommitMessage
     */
    public function parse(string $message): CommitMessage
    {
        $commitMessage = new CommitMessage();

        return $commitMessage;
    }
}
