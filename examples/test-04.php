<?php

/**
 * Change Configs
 */

require_once('../src/UnitTest.class.php');
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

$unit->printSummary();
$unit->printTests();
$unit->printStats();

?>
<br />
<a href="../index.php">Go back..</a>
