<?php

namespace Alimodev;

class ReportCli implements ReportsInterface
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
    return self::generateTestsList();
  }

  public static function printTests()
  {
    if (!headers_sent())
    {
      header("Content-Type:text/plain");
    }
    echo self::generateTestsList();
  }

  public static function fetchStats()
  {
    return self::generateStats();
  }

  public static function printStats()
  {
    if (!headers_sent())
    {
      header("Content-Type:text/plain");
    }
    echo self::generateStats();
  }

  public static function fetchSummary()
  {
    return self::generateSummary();
  }

  public static function printSummary()
  {
    if (!headers_sent())
    {
      header("Content-Type:text/plain");
    }
    echo self::generateSummary();
  }
  /**
   * Private Methods
   */
  private static function getTestGroupNameIfExists()
  {
   return (!empty(self::$instance->getTestGroupName())) ?
     '['.self::$instance->getTestGroupName().'] ' : '';
  }

  private static function generateSummary()
  {
    $output = '';
    $output .= "\n";
    $output .= self::getTestGroupNameIfExists();
    if (self::$instance->allTestsPassed())
    {
      $output .= 'All Unit Tests Passed Successfully! ';
    } else {
      $output .= 'Test Failed! ';
    }
    $output .= '('. self::$instance->failedTestsCount() . ')';
    $output .= "\n";
    $output .= '--------------------------------------------------------------';
    $output .= "\n";
    return $output;
  }

  private static function generateTestsList()
  {
    $output = '';

    $output .= self::getTestGroupNameIfExists();
    $output .= 'Unit Tests (' . count(self::$instance->getTests()) . ')';
    $output .= "\n";
    $output .= '--------------------------------------------------------------';
    $output .= "\n\n";
    foreach(self::$instance->getTests() as $testFunc)
    {
      $testName = array_keys($testFunc)[0];
      $testArgs = $testFunc[$testName];
      $output .= "\t" . $testName . self::getFormattedArgs($testArgs) . "\n";
    }
    $output .= "\n";
    $output .= '--------------------------------------------------------------';
    $output .= "\n";

    return $output;
  }

  private static function getFormattedArgs($args)
  {
    return '( ' . self::formatArgs($args) . ' )';
  }

  private static function formatArgs($args)
  {
    $formatted = '';
    foreach ($args as $arg)
    {
      $formatted .= print_r($arg, true);
      $formatted .= ', ';
    }
    return trim(trim($formatted), ',');
  }

  private static function generateStats()
  {
    $output = '';
    $output .= self::generateStatsSummary();
    $output .= self::generateStatsFailedReport();
    $output .= self::generateStatsResourceUsage();

    return $output;
  }

  private static function generateStatsSummary()
  {
    $output = '';
    $output .= "\n";
    $output .= self::getTestGroupNameIfExists();
    $output .= 'Unit Test Stats';
    $output .= "\n";
    $output .= '--------------------------------------------------------------';
    $output .= "\n";
    $output .= "   Total Tests:\t\t". count(self::$instance->getTests()) . "\n";
    $output .= "   Executed Tests:\t" .
      (count(self::$instance->getPassedTests()) + count(self::$instance->getFailedTests())) .
      "\n";
    $output .= "   Passed Tests:\t" . count(self::$instance->getPassedTests()) . "\n";
    $output .= "   Failed Tests:\t" . count(self::$instance->getFailedTests()) . "\n";
    $output .= '--------------------------------------------------------------';
    $output .= "\n";

    return $output;
  }

  private static function generateStatsFailedReport()
  {
    $countFailedTests = count(self::$instance->getFailedTests());

    $output = '';
    if ($countFailedTests > 0)
    {
      $output .= "   Failed Tests:\n\n";
      foreach (self::$instance->getFailedTests() as $failedTestName => $failedTestResult)
      {
        if ($failedTestResult === false) {$failedTestResult = 'false';}
        if ($failedTestResult === true) {$failedTestResult = 'true';}
        $output .= "\t" . $failedTestName . ' => returned: (' .
          print_r($failedTestResult, true) . ')' . "\n";
      }
      $output .= "\n";
      $output .= '--------------------------------------------------------------';
      $output .= "\n";
    }

    return $output;
  }

  private static function generateStatsResourceUsage()
  {
    $output = '';
    $output .= "   Elapsed Test Time:\t" . self::$instance->getElapsedTestTime() . "\n";
    $output .= "   Memory Usage:\t" . self::$instance->getMemoryUsage() . "\n";
    $output .= "   Peak Memory Usage:\t" . self::$instance->getPeakMemoryUsage() . "\n";
    $output .= "   Used Configs:\t" . self::generateConfigsString() . "\n";
    $output .= '--------------------------------------------------------------';
    $output .= "\n";

    return $output;
  }

  private static function generateConfigsString()
  {
    $errorReportingStatus = (self::$instance->errorReporting) ? "enabled" : "disabled";
    $debuggingStatus = (self::$instance->debugging) ? "enabled" : "disabled";
    $maxExecutionTime = (self::$instance->maxExecutionTime != 0) ?
      self::$instance->maxExecutionTime . 's' : 'unlimited';

    $output = '';
    $output .= '( Max Execution Time: ' . $maxExecutionTime . ' - ';
    $output .= 'Memory Limit: ' . self::$instance->memoryLimit . ' - ';
    $output .= 'Error Reporting: ' . $errorReportingStatus . ' - ';
    $output .= 'Debugging: ' . $debuggingStatus . ' )';

    return $output;
  }
}

?>
