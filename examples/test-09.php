<?php

/**
 * CLI
 * use command line >> php test-09.php
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new Alimodev\UnitTestAsserts('CLI');

$unit->addTestFunc('testThatReturnsTrue')->assertTrue();
$unit->addTestFunc('testThatReturnsFalse')->assertFalse();
$unit->addTestFunc('testThatReturnsNull')->assertNotNull();

$unit->run();

Alimodev\ReportCli::setInstance($unit);
Alimodev\ReportCli::printSummary();
Alimodev\ReportCli::printStats();

?>
