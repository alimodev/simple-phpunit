<?php

/**
 * Auto Add Test Functions with Pattern
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new Alimodev\UnitTest('Patterns');

$unit->addTestFuncsWithPattern('timely*');
$unit->addTestFuncsWithPattern('testWith*', 'Arg1');

$unit->run();

Alimodev\ReportWeb::setInstance($unit);
Alimodev\ReportWeb::printTests();
Alimodev\ReportWeb::printStats();

?>
<br />
<a href="../index.php">Go back..</a>
