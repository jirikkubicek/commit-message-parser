<?php

namespace CommitMessageParser;

use CommitMessageParser\Interfaces\CommitMessage as CommitMessageInterface;

final class CommitMessage implements CommitMessageInterface
{
    /**
     * @var string
     */
    private string $title;
    /**
     * @var int|null
     */
    private ?int $taskId;
    /**
     * @var string[]
     */
    private array $tags;
    /**
     * @var string[]
     */
    private array $details;
    /**
     * @var string[]
     */
    private array $BCBreaks;
    /**
     * @var string[]
     */
    private array $todos;

    /**
     * @param string $title
     * @return CommitMessage
     */
    public function setTitle(string $title): CommitMessage
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param int|null $taskId
     * @return CommitMessage
     */
    public function setTaskId(?int $taskId): CommitMessage
    {
        $this->taskId = $taskId;
        return $this;
    }

    /**
     * @param string[] $tags
     * @return CommitMessage
     */
    public function setTags(array $tags): CommitMessage
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param string[] $details
     * @return CommitMessage
     */
    public function setDetails(array $details): CommitMessage
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @param string[] $BCBreaks
     * @return CommitMessage
     */
    public function setBCBreaks(array $BCBreaks): CommitMessage
    {
        $this->BCBreaks = $BCBreaks;
        return $this;
    }

    /**
     * @param string[] $todos
     * @return CommitMessage
     */
    public function setTodos(array $todos): CommitMessage
    {
        $this->todos = $todos;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getTaskId(): ?int
    {
        return $this->taskId;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return string[]
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @return string[]
     */
    public function getBCBreaks(): array
    {
        return $this->BCBreaks;
    }

    /**
     * @return string[]
     */
    public function getTodos(): array
    {
        return $this->todos;
    }
}
