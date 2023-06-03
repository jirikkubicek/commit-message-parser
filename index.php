<?php

require_once("vendor/autoload.php");

use CommitMessageParser\CommitMessageParser;

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
$commitMessageParser->setCaseSensitive(false);
$commitMessageEntity = $commitMessageParser->parse($testMessage);
