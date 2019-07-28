<?php

/**
 * Auto Add Test Functions with Pattern
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new UnitTest('Patterns');

$unit->addTestFuncsWithPattern('timely*');
$unit->addTestFuncsWithPattern('testWith*', 'Arg1');

$unit->run();

ReportWeb::setInstance($unit);
ReportWeb::printTests();
ReportWeb::printStats();

?>
<br />
<a href="../index.php">Go back..</a>
