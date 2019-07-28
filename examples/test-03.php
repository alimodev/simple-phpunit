<?php

/**
 * Run last test only
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new Alimodev\UnitTest();

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

Alimodev\ReportWeb::setInstance($unit);
Alimodev\ReportWeb::printSummary();
Alimodev\ReportWeb::printTests();
Alimodev\ReportWeb::printStats();

?>
<br />
<a href="../index.php">Go back..</a>
