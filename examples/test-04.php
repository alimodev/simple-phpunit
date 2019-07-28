<?php

/**
 * Change Configs
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new Alimodev\UnitTest();

$unit->maxExecutionTime = 60;
$unit->memoryLimit = '64M';
$unit->errorReporting = true;
$unit->debugging = true;
$unit->applyConfigs();


$unit->addTestFunc('testThatReturnsString');
$unit->addTestFunc('testThatReturnsNumber');
$unit->addTestFunc('testWithInputArgs', 'Ali');


$unit->run();

Alimodev\ReportWeb::setInstance($unit);
Alimodev\ReportWeb::printSummary();
Alimodev\ReportWeb::printTests();
Alimodev\ReportWeb::printStats();

?>
<br />
<a href="../index.php">Go back..</a>
