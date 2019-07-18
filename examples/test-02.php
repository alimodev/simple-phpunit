<?php

/**
 * Basic Usage Example
 */

require_once('../src/UnitTest.class.php');
require_once('testFunctions.php');

$unit = new UnitTest('Basic');

$unit->addTestFunc('testThatReturnsTrue');
$unit->addTestFunc('testThatReturnsFalse');
$unit->addTestFunc('testThatReturnsNull');
$unit->addTestFunc('testThatReturnsString');
$unit->addTestFunc('testThatReturnsNumber');
$unit->addTestFunc('testWithInputArgs', 'Ali');
$unit->addTestFunc('timelyTestThatReturnsTrue');

$unit->removeTestFunc('testThatReturnsNull');

$unit->run();

$unit->printSummary();
$unit->printTests();
$unit->printStats();

?>
<br />
<a href="../index.php">Go back..</a>
