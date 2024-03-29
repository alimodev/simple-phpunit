<?php

/**
 * Multiple Instances Example
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

// 1st Group Of Unit Tests
$unit1 = new Alimodev\UnitTest('Group1');

$unit1->addTestFunc('testThatReturnsTrue');
$unit1->addTestFunc('testThatReturnsFalse');
$unit1->addTestFunc('testThatReturnsNull');

$unit1->run();

Alimodev\ReportWeb::setInstance($unit1);
Alimodev\ReportWeb::printStats();

// 2nd Group Of Unit Tests
$unit2 = new Alimodev\UnitTest('Group2');

$unit2->addTestFunc('testThatReturnsString');
$unit2->addTestFunc('testThatReturnsNumber');
$unit2->addTestFunc('testWithInputArgs', 'Ali');
$unit2->addTestFunc('timelyTestThatReturnsTrue');

$unit2->run();

Alimodev\ReportWeb::setInstance($unit2);
Alimodev\ReportWeb::printStats();

?>
<br />
<a href="../index.php">Go back..</a>
