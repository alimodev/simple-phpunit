<?php

/**
 * Multiple Instances Example
 */

require_once('../src/UnitTest.class.php');
require_once('testFunctions.php');

// 1st Group Of Unit Tests
$unit1 = new UnitTest('Group1');

$unit1->addTestFunc('testThatReturnsTrue');
$unit1->addTestFunc('testThatReturnsFalse');
$unit1->addTestFunc('testThatReturnsNull');

$unit1->run();
$unit1->printStats();

// 2nd Group Of Unit Tests
$unit2 = new UnitTest('Group2');

$unit2->addTestFunc('testThatReturnsString');
$unit2->addTestFunc('testThatReturnsNumber');
$unit2->addTestFunc('testWithInputArgs', 'Ali');
$unit2->addTestFunc('timelyTestThatReturnsTrue');

$unit2->run();
$unit2->printStats();

?>
<br />
<a href="../index.php">Go back..</a>
