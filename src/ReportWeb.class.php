<?php

namespace Alimodev;

class ReportWeb implements ReportsInterface
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
    echo self::generateTestsList();
  }

  public static function fetchStats()
  {
    return self::generateStats();
  }

  public static function printStats()
  {
    echo self::generateStats();
  }

  public static function fetchSummary()
  {
    return self::generateSummary();
  }

  public static function printSummary()
  {
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

    if (self::$instance->allTestsPassed())
    {
      $output .= '<h1 style="color:green">';
      $output .= self::getTestGroupNameIfExists();
      $output .= 'All Unit Tests Passed Successfully! ('.
        self::$instance->passedTestsCount().')</h1>';
    } else {
      $output .= '<h1 style="color:red">';
      $output .= self::getTestGroupNameIfExists();
      $output .= 'Test Failed! ('.
        self::$instance->failedTestsCount().')</h1>';
    }

    return $output;
  }

  private static function generateTestsList()
  {
    $output = '';

    $output .= '<h2>';
    $output .= self::getTestGroupNameIfExists();
    $output .= 'Unit Tests (' . count(self::$instance->getTests()) . ')</h2>';
    $output .= '<ul>';
    foreach(self::$instance->getTests() as $testFunc)
    {
      $testName = array_keys($testFunc)[0];
      $testArgs = $testFunc[$testName];
      $output .= '<li>' . $testName . self::getFormattedArgs($testArgs) . '</li>';
    }
    $output .= '</ul>';

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
    $output .= '<h2>';
    $output .= self::getTestGroupNameIfExists();
    $output .= 'Unit Test Stats</h2>';
    $output .= '<hr />';
    $output .= '<table>';
    $output .= '<tr style="color:#444"><td>Total Tests:</td>';
		$output .= '<td>' . count(self::$instance->getTests()) . '</td>';
    $output .= '</tr><tr style="color:#0d0df3"><td>Executed Tests:</td>';
    $output .= '<td>' . (count(self::$instance->getPassedTests()) + count(self::$instance->getFailedTests())) . '</td>';
    $output .= '</tr><tr style="color:#609424"><td>Passed Tests:</td>';
		$output .= '<td>' . count(self::$instance->getPassedTests()) . '</td>';
    $output .= '</tr><tr style="color:#e21919"><td>Failed Tests:</td>';
		$output .= '<td>' . count(self::$instance->getFailedTests()) . '</td>';
    $output .= '</tr></table>';
    $output .= '<hr />';

    return $output;
  }

  private static function generateStatsFailedReport()
  {
    $countFailedTests = count(self::$instance->getFailedTests());

    $output = '';
    if ($countFailedTests > 0)
    {
      $output .= '<h4 style="color:#bd144d">Failed Test:</h4>';
      $output .= '<div style="color:red"><ul>';
      foreach (self::$instance->getFailedTests() as $failedTestName => $failedTestResult)
      {
        if ($failedTestResult === false) {$failedTestResult = 'false';}
        if ($failedTestResult === true) {$failedTestResult = 'true';}
        $output .= '<li>' . $failedTestName . ' => returned: (' .
          print_r($failedTestResult, true) . ')' . '</li>';
      }
      $output .= '</div>';
      $output .= '<hr />';
    }

    return $output;
  }

  private static function generateStatsResourceUsage()
  {
    $output = '';
    $output .= '<table style="color:#333"><tr>';
    $output .= '<td>Elapsed Test Time:</td>';
    $output .= '<td>' . self::$instance->getElapsedTestTime() . '</td>';
    $output .= '</tr><tr><td>Memory Usage:</td>';
    $output .= '<td>' . self::$instance->getMemoryUsage() . '</td>';
    $output .= '</tr><tr><td>Peak Memory Usage:</td>';
    $output .= '<td>' . self::$instance->getPeakMemoryUsage() . '</td>';
    $output .= '</tr><tr><td>Used Configs:</td>';
    $output .= '<td>' . self::generateConfigsString() . '</td>';
    $output .= '</tr></table>';
    $output .= '<hr /><br /><br />';

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
