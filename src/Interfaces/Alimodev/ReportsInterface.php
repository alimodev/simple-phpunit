<?php

namespace Alimodev;

interface ReportsInterface
{
  public static function setInstance($instance);

  public static function fetchTests();
  public static function printTests();

  public static function fetchStats();
  public static function printStats();

  public static function fetchSummary();
  public static function printSummary();
}

?>
