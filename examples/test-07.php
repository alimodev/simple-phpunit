<?php

/**
 * JSON Output
 */
require_once('../src/loader.php');
require_once('testFunctions.php');

$unit = new Alimodev\UnitTest('API');

$unit->addTestFuncsWithPattern('test*');

$unit->run();

Alimodev\ReportJson::setInstance($unit);
Alimodev\ReportJson::printStats();
