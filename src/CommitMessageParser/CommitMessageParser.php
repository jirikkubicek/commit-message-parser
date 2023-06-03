<?php

namespace CommitMessageParser;

use CommitMessageParser\Interfaces\CommitMessageParser as CommitMessageParserInterface;

final class CommitMessageParser implements CommitMessageParserInterface
{
    /**
     * string[]
     */
    private const DETAILS_START_CHAR = [
      "*"
    ];

    /**
     * string[]
     */
    private const TODOS_START_CHAR = [
        "TODO:"
    ];

    /**
     * string[]
     */
    private const BC_BREAKS_START_CHAR = [
        "BC:"
    ];

    /**
     * @var bool
     */
    private bool $caseSensitive = false;

    /**
     * @param string $message
     * @return CommitMessage
     */
    public function parse(string $message): CommitMessage
    {
        $subjectLine = $this->getSubjectLine($message);
        $bodyLines = $this->getBodyLines($message);

        $commitMessage = new CommitMessage();
        $commitMessage
            ->setTaskId($this->getTaskId($subjectLine))
            ->setTitle($this->getTitle($subjectLine))
            ->setTags($this->getTags($subjectLine))
            ->setDetails($this->getDetails($bodyLines))
            ->setTodos($this->getTodos($bodyLines))
            ->setBCBreaks($this->getBCBreaks($bodyLines));

        return $commitMessage;
    }

    /**
     * @param bool $caseSensitive
     * @return $this
     */
    public function setCaseSensitive(bool $caseSensitive = true): self
    {
        $this->caseSensitive = $caseSensitive;
        return $this;
    }

    /**
     * @param string $line
     * @return int|null
     */
    private function getTaskId(string $line): ?int
    {
        preg_match("/#(\d+)/", $line, $taskId);

        if (isset($taskId[1])) {
            return (int) $taskId[1];
        }

        return null;
    }

    /**
     * @param string $line
     * @return string
     */
    private function getTitle(string $line): string
    {
        $title = preg_replace("/\[(.*)]|[#@]\S*/", "", $line);

        return trim((string) $title);
    }

    /**
     *
     * @param string $line
     * @return string[]
     */
    private function getTags(string $line): array
    {
        preg_match_all("/\[(.*?)]/", $line, $tags);

        return ($tags[1] ?? []);
    }

    /**
     * @param string[] $lines
     * @return string[]
     */
    private function getDetails(array $lines): array
    {
        return $this->getTrimmedLinesStartingWith(self::DETAILS_START_CHAR, $lines, $this->caseSensitive);
    }

    /**
     * @param string[] $lines
     * @return string[]
     */
    private function getTodos(array $lines): array
    {
        return $this->getTrimmedLinesStartingWith(self::TODOS_START_CHAR, $lines, $this->caseSensitive);
    }

    /**
     * @param string[] $lines
     * @return string[]
     */
    private function getBCBreaks(array $lines): array
    {
        return $this->getTrimmedLinesStartingWith(self::BC_BREAKS_START_CHAR, $lines, $this->caseSensitive);
    }

    /**
     * @param string $message
     * @return string
     */
    private function getSubjectLine(string $message): string
    {
        $lines = $this->splitByLines($message);

        return ($lines[0] ?? "");
    }

    /**
     * @param string $message
     * @return string[]
     */
    private function getBodyLines(string $message): array
    {
        $lines = $this->splitByLines($message);

        if (isset($lines[0])) {
            unset($lines[0]);
        }

        return $lines;
    }

    /**
     * @param string $message
     * @return string[]
     */
    private function splitByLines(string $message): array
    {
        $lines = preg_split("/\r\n|\n|\r/", $message);

        if (is_array($lines)) {
            array_walk($lines, function (string &$line, int $key) {
                $line = trim($line);
            });

            $lines = array_filter($lines);
            return array_values($lines);
        }

        return [];
    }

    /**
     * @param string|string[] $needles
     * @param string[] $lines
     * @param bool $caseSensitive
     * @return string[]
     */
    private function getTrimmedLinesStartingWith(
        string|array $needles,
        array $lines,
        bool $caseSensitive = false
    ): array {
        $matchingLines = $this->getLinesStartingWith($needles, $lines, $caseSensitive);

        return $this->trimArrayValuesByChar($needles, $matchingLines, $caseSensitive);
    }

    /**
     * @param string|string[] $needles
     * @param string[] $lines
     * @param bool $caseSensitive
     * @return string[]
     */
    private function getLinesStartingWith(
        string|array $needles,
        array $lines,
        bool $caseSensitive = false
    ): array {
        $matchingLines = [];

        foreach ($lines as $line) {
            if (is_array($needles)) {
                foreach ($needles as $needle) {
                    if (
                        str_starts_with(
                            $caseSensitive ? $line : strtolower($line),
                            $caseSensitive ? $needle : strtolower($needle)
                        )
                    ) {
                        $matchingLines[] = $line;

                        break;
                    }
                }
            } elseif (is_string($needles)) {
                if (
                    str_starts_with(
                        $caseSensitive ? $line : strtolower($line),
                        $caseSensitive ? $needles : strtolower($needles)
                    )
                ) {
                    $matchingLines[] = $line;
                }
            }
        }

        return $matchingLines;
    }

    /**
     * @param string|string[] $needles
     * @param string[] $lines
     * @param bool $caseSensitive
     * @return string[]
     */
    private function trimArrayValuesByChar(
        string|array $needles,
        array $lines,
        bool $caseSensitive = false
    ): array {
        $trimmedArray = [];

        foreach ($lines as $line) {
            if (is_array($needles)) {
                foreach ($needles as $char) {
                    if (
                        str_starts_with(
                            $caseSensitive ? $line : strtolower($line),
                            $caseSensitive ? $char : strtolower($char)
                        )
                    ) {
                        $trimmedArray[] = trim(substr($line, strlen($char)));

                        break;
                    }
                }
            } elseif (is_string($needles)) {
                $trimmedArray[] = trim(substr($line, strlen($needles)));
            }
        }

        return $trimmedArray;
    }
}
