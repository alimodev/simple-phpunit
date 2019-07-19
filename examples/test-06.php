<?php

/**
 * Auto Add Test Functions with Pattern
 */

require_once('../src/UnitTest.class.php');
require_once('testFunctions.php');

$unit = new UnitTest('Basic');

$unit->addTestFuncsWithPattern('timely*');
$unit->addTestFuncsWithPattern('testWith*', 'Arg1');

$unit->run();

$unit->printTests();
$unit->printStats();

?>
<br />
<a href="../index.php">Go back..</a>
