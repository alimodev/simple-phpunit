<?php

/**
 * Asserts
 */

require_once('../src/UnitTestAsserts.class.php');
require_once('testFunctions.php');

$unit = new UnitTestAsserts('Asserts');

$unit->addTestFuncsWithPattern('test*')->assertFalse();
$unit->addTestFunc('testWithInputArgs', 'arg2')->assertTrue();
$unit->addTestFunc('testWithInputArgs', 'arg3')->assertTrue();
$unit->addTestFunc('testWithInputArgs', 'arg4')->assertTrue();

$unit->run();

$unit->printStats();
?>
<br />
<a href="../index.php">Go back..</a>
