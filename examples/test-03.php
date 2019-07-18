<?php

/**
 * Run last test only
 */

require_once('../src/UnitTest.class.php');
require_once('testFunctions.php');

$unit = new UnitTest();

$unit->addTestFunc('testThatReturnsString');
$unit->addTestFunc('testThatReturnsNumber');
$unit->addTestFunc('testWithInputArgs', 'Ali');


$unit->runLastTest();

$unit->printSummary();
$unit->printTests();
$unit->printStats();

?>
<br />
<a href="../index.php">Go back..</a>
