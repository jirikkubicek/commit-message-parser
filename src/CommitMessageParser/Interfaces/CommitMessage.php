<?php

namespace CommitMessageParser\Interfaces;

interface CommitMessage
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return int|null
     */
    public function getTaskId(): ?int;

    /**
     * @return string[]
     */
    public function getTags(): array;

    /**
     * @return string[]
     */
    public function getDetails(): array;

    /**
     * @return string[]
     */
    public function getBCBreaks(): array;

    /**
     * @return string[]
     */
    public function getTodos(): array;
}
