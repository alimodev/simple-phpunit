<?php

/**
 * Asserts
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new UnitTestAsserts('Asserts');

$unit->addTestFunc('testThatReturnsTrue')->assertTrue();
$unit->addTestFunc('testThatReturnsFalse')->assertFalse();
$unit->addTestFunc('testThatReturnsNull')->assertEmpty();
$unit->addTestFunc('testThatReturnsString')->assertEquals('Hello World!');
$unit->addTestFunc('testThatReturnsNumber')->assertNumber();
$unit->addTestFunc('testWithInputArgs', 'Ali')->assertNotString();
$unit->addTestFunc('timelyTestThatReturnsTrue')->assertEmpty();
$unit->addTestFuncsWithPattern('timely*')->assertNotTrue();

$unit->run();

ReportWeb::setInstance($unit);
ReportWeb::printStats();

?>
<br />
<a href="../index.php">Go back..</a>
