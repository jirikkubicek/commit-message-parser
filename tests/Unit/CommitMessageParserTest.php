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

    public function testParserTwo()
    {
        $testMessage = "
            #25 [some another tag] Testovací commit message [add] [new feature]
            ---
            * Přidána nová funkcionalita.
            *Nějaký další detailní popis úpravy.
            **Další popis.
            *Detail
            
            
            bc: Upravená funkčnost předchozí verze.
            BC:...
            bc:
            bc:-
            
            * Nový logger.
            
            TODO: Udělat refactoring.
            todo:Vytvořit dokumentaci
            todo:Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi scelerisque luctus velit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis condimentum augue id magna semper rutrum. Suspendisse nisl. Aliquam ornare wisi eu metus. Sed vel lectus. Donec odio tempus molestie, porttitor ut, iaculis quis, sem. Phasellus faucibus molestie nisl. Suspendisse nisl. Donec quis nibh at felis congue commodo.
        ";

        $commitMessageParser = new CommitMessageParser();
        $commitMessage = $commitMessageParser->parse($testMessage);

        $this->assertEquals("Testovací commit message", $commitMessage->getTitle());

        $this->assertEquals(25, $commitMessage->getTaskId());

        $this->assertContains("add", $commitMessage->getTags());
        $this->assertContains("new feature", $commitMessage->getTags());
        $this->assertContains("some another tag", $commitMessage->getTags());

        $this->assertContains("Přidána nová funkcionalita.", $commitMessage->getDetails());
        $this->assertContains("Nějaký další detailní popis úpravy.", $commitMessage->getDetails());
        $this->assertContains("*Další popis.", $commitMessage->getDetails());
        $this->assertContains("Detail", $commitMessage->getDetails());
        $this->assertContains("Nový logger.", $commitMessage->getDetails());

        $this->assertContains("Upravená funkčnost předchozí verze.", $commitMessage->getBCBreaks());
        $this->assertContains("...", $commitMessage->getBCBreaks());
        $this->assertContains("", $commitMessage->getBCBreaks());
        $this->assertContains("-", $commitMessage->getBCBreaks());

        $this->assertContains("Udělat refactoring.", $commitMessage->getTodos());
        $this->assertContains("Vytvořit dokumentaci", $commitMessage->getTodos());
        $this->assertContains("Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi scelerisque luctus velit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis condimentum augue id magna semper rutrum. Suspendisse nisl. Aliquam ornare wisi eu metus. Sed vel lectus. Donec odio tempus molestie, porttitor ut, iaculis quis, sem. Phasellus faucibus molestie nisl. Suspendisse nisl. Donec quis nibh at felis congue commodo.", $commitMessage->getTodos());
    }
}
