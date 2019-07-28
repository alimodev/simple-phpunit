<?php

namespace Alimodev;

class ReportJson implements ReportsInterface
{
  /**
   * Properties
   */
  private static $instance;

  /**
   * Public Methods
   */
  public static function setInstance($instance)
  {
    self::$instance = $instance;
  }

  public static function fetchTests()
  {
    return json_encode(self::generateTestsList());
  }

  public static function printTests()
  {
    if (!headers_sent())
    {
      header('Content-type: application/json');
    }
    echo self::fetchTests();
  }

  public static function fetchStats()
  {
    return json_encode(self::generateStats());
  }

  public static function printStats()
  {
    if (!headers_sent())
    {
      header('Content-type: application/json');
    }
    echo self::fetchStats();
  }

  public static function fetchSummary()
  {
    return json_encode(self::generateSummary());
  }

  public static function printSummary()
  {
    if (!headers_sent())
    {
      header('Content-type: application/json');
    }
    echo self::fetchSummary();
  }
  /**
   * Private Methods
   */
  private static function generateTestsList()
  {
    $report = array();

    $report['testGroupName'] = self::$instance->getTestGroupName();
    $report['testFunctionsCount'] = count(self::$instance->getTests());
    $report['testFunctions'] = self::$instance->getTests();

    return $report;
  }

  private static function generateStats()
  {
    $report = array();

    $report['allTestsPassed'] = self::$instance->allTestsPassed();
    $report['testGroupName'] = self::$instance->getTestGroupName();
    $report['totalTestsCount'] = count(self::$instance->getTests());
    $report['ExecutedTestsCount'] = (count(self::$instance->getPassedTests()) +
      count(self::$instance->getFailedTests()));
    $report['passedTestsCount'] = count(self::$instance->getPassedTests());
    $report['failedTestsCount'] = count(self::$instance->getFailedTests());
    $report['failedTests'] = self::$instance->getFailedTests();
    $report['elapsedTestTime'] = self::$instance->getElapsedTestTime();
    $report['memoryUsage'] = self::$instance->getMemoryUsage();
    $report['peakMemoryUsage'] = self::$instance->getPeakMemoryUsage();

    return $report;
  }

  private static function generateSummary()
  {
    $report = array();

    $report['allTestsPassed'] = self::$instance->allTestsPassed();
    $report['totalTestsCount'] = count(self::$instance->getTests());
    $report['passedTestsCount'] = count(self::$instance->getPassedTests());
    $report['failedTestsCount'] = count(self::$instance->getFailedTests());

    return $report;
  }
}

?>
