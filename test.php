<?php

require_once('UnitTest.class.php');
require_once('testFunctions.php');

$unit = new UnitTest();

$unit->addTestFunc('testFunc1');
$unit->addTestFunc('testFunc2');
$unit->addTestFunc('testFunc3');
$unit->addTestFunc('testFunc4', '#4');

//$unit->removeTestFunc('testFunc2');
$unit->removeTestFunc('testFunc3');

$unit->run();

if ($unit->allTestsPassed())
{
  echo '<h1 style="color:green">All Unit Tests Passed Successfully! ('.
    $unit->passedTestsCount().')</h1>';
} else {
  echo '<h1 style="color:red">Test Failed! ('.
    $unit->failedTestsCount().')</h1>';
}

$unit->printTests();
$unit->printStats();

?>
