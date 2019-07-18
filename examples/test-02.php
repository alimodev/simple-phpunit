<?php

require_once('../src/UnitTest.class.php');
require_once('testFunctions.php');

$unit = new UnitTest();

$unit->addTestFunc('testFunc1');
$unit->addTestFunc('testFunc2');
$unit->addTestFunc('testFunc3');
$unit->addTestFunc('testFunc4', '#4');

$unit->removeTestFunc('testFunc2');

$unit->run();

$unit->printSummary();
$unit->printTests();
$unit->printStats();

?>
<br /><hr />
<a href="../index.php">Go back..</a>
