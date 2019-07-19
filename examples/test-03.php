<?php

/**
 * Run last test only
 */

require_once('../src/UnitTest.class.php');
require_once('testFunctions.php');

$unit = new UnitTest();

$unit->addTestFunc('testThatReturnsTrue');
$unit->addTestFunc('testThatReturnsFalse');
$unit->addTestFunc('testThatReturnsNull');
$unit->addTestFunc('testThatReturnsString');
$unit->addTestFunc('testThatReturnsNumber');
$unit->addTestFunc('testWithInputArgs', 'Ali');
$unit->addTestFunc('timelyTestThatReturnsTrue');


$unit->runLastTest();
$unit->runFirstTest();
$unit->runThisTest('testThatReturnsNumber');

$unit->printSummary();
$unit->printTests();
$unit->printStats();

?>
<br />
<a href="../index.php">Go back..</a>
