<?php

/**
 * JSON Output
 */

require_once('../src/UnitTest.class.php');
require_once('testFunctions.php');

$unit = new UnitTest('API');

$unit->addTestFuncsWithPattern('test*');

$unit->run();

$unit->printJsonReport();
?>
