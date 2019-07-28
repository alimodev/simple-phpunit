<?php

/**
 * Change Configs
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new UnitTest();

$unit->maxExecutionTime = 60;
$unit->memoryLimit = '64M';
$unit->errorReporting = true;
$unit->debugging = true;
$unit->applyConfigs();


$unit->addTestFunc('testThatReturnsString');
$unit->addTestFunc('testThatReturnsNumber');
$unit->addTestFunc('testWithInputArgs', 'Ali');


$unit->run();

ReportWeb::setInstance($unit);
ReportWeb::printSummary();
ReportWeb::printTests();
ReportWeb::printStats();

?>
<br />
<a href="../index.php">Go back..</a>
