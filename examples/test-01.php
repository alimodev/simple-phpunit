<?php

/**
 * Essential Usage Example
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new UnitTest();

$unit->addTestFunc('testThatReturnsTrue');
$unit->addTestFunc('testThatReturnsFalse');
$unit->addTestFunc('testThatReturnsNull');
$unit->addTestFunc('testThatReturnsString');
$unit->addTestFunc('testThatReturnsNumber');
$unit->addTestFunc('testWithInputArgs', 'Ali');
$unit->addTestFunc('timelyTestThatReturnsTrue');

$unit->run();

ReportWeb::setInstance($unit);
ReportWeb::printStats();

?>
<br />
<a href="../index.php">Go back..</a>
