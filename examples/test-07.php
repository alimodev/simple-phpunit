<?php

/**
 * JSON Output
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new UnitTest('API');

$unit->addTestFuncsWithPattern('test*');

$unit->run();

ReportJson::setInstance($unit);
ReportJson::printStats();
