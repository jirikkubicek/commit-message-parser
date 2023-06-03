<?php

namespace Tests\Unit;

use CommitMessageParser\CommitMessageParser;
use Tests\Support\UnitTester;

class CommitMessageParserTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    public function testParser()
    {
        $testMessage = "
            [add] [feature] @core #123456 Integrovat Premier: export objednávek
            
            * Export objednávek cronem co hodinu.
            * Export probíhá v dávkách.
            * ...
            
            BC: Refaktorovaný BaseImporter.
            BC: ...
            
            Feature: Nový logger.
            
            TODO: Refactoring autoemail modulu.
        ";

        $commitMessageParser = new CommitMessageParser();
        $commitMessage = $commitMessageParser->parse($testMessage);

        $this->assertEquals("Integrovat Premier: export objednávek", $commitMessage->getTitle());

        $this->assertEquals(123456, $commitMessage->getTaskId());

        $this->assertContains("add", $commitMessage->getTags());
        $this->assertContains("feature", $commitMessage->getTags());

        $this->assertContains("Export objednávek cronem co hodinu.", $commitMessage->getDetails());
        $this->assertContains("Export probíhá v dávkách.", $commitMessage->getDetails());
        $this->assertContains("...", $commitMessage->getDetails());

        $this->assertContains("Refaktorovaný BaseImporter.", $commitMessage->getBCBreaks());
        $this->assertContains("...", $commitMessage->getBCBreaks());

        $this->assertContains("Refactoring autoemail modulu.", $commitMessage->getTodos());
    }
}
