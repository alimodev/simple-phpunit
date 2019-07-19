<?php

/**
 * Unit Testing Class
 * by ALireza Mortazavi
 * https://github.com/alimodev/
 */
class UnitTest
{
  /**
   * Object Decleration
   */
  public $maxExecutionTime = 100; // in seconds, 0 for unlimited
  public $memoryLimit = '128M';
  public $errorReporting = true;
  public $debugging = false;

  private $testGroupName = '';
  private $elapsedTestTime = 0;
  private $memoryUsage = 0;
  private $peakMemoryUsage = 0;
  private $testFunctions = array();
  private $passedTests = array();
  private $failedTests = array();

  function __construct($instanceName = '')
  {
    $this->configEnviroment();
    $this->testGroupName = $instanceName;
  }

  /**
   * Public Methods
   */
  public function applyConfigs()
  {
    $this->configEnviroment();
  }

  public function run($testsToRun = '')
  {
    $startTime = microtime(true);
    // do all tests
    $this->runAllTests($testsToRun);
    // calc time and memory usage
    $this->calcElapsedTime($startTime);
    $this->calcMemoryUsage();
  }

  public function runLastTest()
  {
    $lastTest = array_keys($this->testFunctions)[count($this->testFunctions)-1];
    $filteredTests = $this->filterTests($lastTest);
    $this->run($filteredTests);
  }

  public function runFirstTest()
  {
    $firstTest = array_keys($this->testFunctions)[0];
    $filteredTests = $this->filterTests($firstTest);
    $this->run($filteredTests);
  }

  public function runThisTest($testName)
  {
    $filteredTests = $this->filterTests($testName);
    $this->run($filteredTests);
  }

  public function addTestFunc($functionName, ...$functionArgs)
  {
    if (
      function_exists($functionName) &&
      !$this->testExists($functionName)
      )
    {
      $this->testFunctions[$functionName] = $functionArgs;
    }
  }

  public function addTestFuncsWithPattern($namePattern = '*', ...$args)
  {
    $allDefinedFuncs = get_defined_functions();
    $allUserDefinedFuncs = $allDefinedFuncs['user'];

    foreach ($allUserDefinedFuncs as $functionName)
    {
      if (fnmatch($namePattern, $functionName, FNM_CASEFOLD))
      {
        $this->addTestFunc($functionName, ...$args);
      }
    }
  }

  public function removeTestFunc($functionName)
  {
    if ($this->testExists($functionName))
    {
      unset($this->testFunctions[$functionName]);
    }
  }

  public function removeAllTests()
  {
    unset($this->testFunctions);
  }

  public function getTests()
  {
    return $this->testFunctions;
  }

  public function printTests()
  {
    echo $this->generateTestsList();
  }

  public function printStats()
  {
    echo $this->generateStats();
  }

  public function allTestsPassed()
  {
    if (count($this->failedTests) == 0)
    {
      return true;
    }
    return false;
  }

  public function passedTestsCount()
  {
    return count($this->passedTests);
  }

  public function failedTestsCount()
  {
    return count($this->failedTests);
  }

  public function printSummary()
  {
    echo $this->generateSummary();
  }

  public function getReportArray()
  {
    return $this->generateReportArray();
  }

  public function getJsonReport()
  {
    return json_encode($this->getReportArray());
  }

  public function printJsonReport()
  {
    header('Content-type: application/json');
    echo $this->getJsonReport();
  }

  /**
   * Private Methods
   */
  private function configEnviroment()
  {
     set_time_limit($this->maxExecutionTime);
     ini_set("memory_limit", $this->memoryLimit);
     if ($this->errorReporting)
     {
       ini_set('display_startup_errors', 1);
       ini_set('display_errors', 1);
       error_reporting(-1);
     }
  }

  private function runAllTests($testsToRun)
  {
    if (empty($testsToRun))
    {
      $testsToRun = $this->getTests();
    }
    foreach($testsToRun as $testName => $testArg)
    {
      ob_start();
      $runResult = call_user_func($testName, ...$testArg);
      $bufferedOutput = ob_get_contents();
      ob_end_clean();

      $this->printDebuggingInfo($testName, $bufferedOutput);
      $this->assert($testName, $runResult, false);
    }
  }

  private function assert($testName, $runResult, $assertCondition)
  {
    if ($runResult === $assertCondition)
    {
      $this->failedTests[$testName] = $runResult;
    } else {
      $this->passedTests[$testName] = $runResult;
    }
  }

  private function testExists($testName)
  {
    return in_array($testName, array_keys($this->testFunctions));
  }

  private function filterTests($testName)
  {
    return array_filter($this->testFunctions,
      function($key) use($testName){
          return $key == $testName;
    }, ARRAY_FILTER_USE_KEY);
  }

  private function printDebuggingInfo($testName, $bufferedOutput)
  {
    if ($this->debugging && !empty($bufferedOutput))
    {
      echo '<b style="color:#f5980f">[ Debug ] ';
      echo '[ ' . date('Y/m/d H:i:s') . ' ] ' . $testName . ' : </b><br />';
      echo $bufferedOutput;
      echo '<br /><br />';
    }
  }

  private function getTestGroupNameIfExists()
  {
    return (!empty($this->testGroupName)) ?
      '['.$this->testGroupName.'] ' : '';
  }

  private function generateSummary()
  {
    $output = '';

    if ($this->allTestsPassed())
    {
      $output .= '<h1 style="color:green">';
      $output .= $this->getTestGroupNameIfExists();
      $output .= 'All Unit Tests Passed Successfully! ('.
        $this->passedTestsCount().')</h1>';
    } else {
      $output .= '<h1 style="color:red">';
      $output .= $this->getTestGroupNameIfExists();
      $output .= 'Test Failed! ('.
        $this->failedTestsCount().')</h1>';
    }

    return $output;
  }

  private function generateTestsList()
  {
    $output = '';

    $output .= '<h2>';
    $output .= $this->getTestGroupNameIfExists();
    $output .= 'Unit Tests</h2>';
    $output .= '<ul>';
    foreach($this->getTests() as $testName => $testArg)
    {
      $output .= '<li>' . $testName . "</li>";
    }
    $output .= '</ul>';

    return $output;
  }

  private function generateStats()
  {
    $output = '';
    $output .= $this->generateStatsSummary();
    $output .= $this->generateStatsFailedReport();
    $output .= $this->generateStatsResourceUsage();

    return $output;
  }

  private function generateReportArray()
  {
    $report = array();

    $report['allTestsPassed'] = $this->allTestsPassed();
    $report['testGroupName'] = $this->testGroupName;
    $report['totalTestsCount'] = count($this->testFunctions);
    $report['ExecutedTestsCount'] = (count($this->passedTests) + count($this->failedTests));
    $report['passedTestsCount'] = count($this->passedTests);
    $report['failedTestsCount'] = count($this->failedTests);
    $report['failedTests'] = $this->failedTests;
    $report['elapsedTestTime'] = $this->elapsedTestTime;
    $report['memoryUsage'] = $this->formatBytes($this->memoryUsage);
    $report['peakMemoryUsage'] = $this->formatBytes($this->peakMemoryUsage);

    return $report;
  }

  private function generateStatsSummary()
  {
    $output = '';
    $output .= '<h2>';
    $output .= $this->getTestGroupNameIfExists();
    $output .= 'Unit Test Stats</h2>';
    $output .= '<hr />';
    $output .= '<table>';
    $output .= '<tr style="color:#444"><td>Total Tests:</td>';
		$output .= '<td>' . count($this->testFunctions) . '</td>';
    $output .= '</tr><tr style="color:#0d0df3"><td>Executed Tests:</td>';
    $output .= '<td>' . (count($this->passedTests) + count($this->failedTests)) . '</td>';
    $output .= '</tr><tr style="color:#609424"><td>Passed Tests:</td>';
		$output .= '<td>' . count($this->passedTests) . '</td>';
    $output .= '</tr><tr style="color:#e21919"><td>Failed Tests:</td>';
		$output .= '<td>' . count($this->failedTests) . '</td>';
    $output .= '</tr></table>';
    $output .= '<hr />';

    return $output;
  }

  private function generateStatsFailedReport()
  {
    $countFailedTests = count($this->failedTests);

    $output = '';
    if ($countFailedTests > 0)
    {
      $output .= '<h4 style="color:#bd144d">Failed Test:</h4>';
      $output .= '<div style="color:red"><ul>';
      foreach ($this->failedTests as $failedTestName => $failedTestResult)
      {
        $output .= '<li>' . $failedTestName . '</li>';
      }
      $output .= '</div>';
      $output .= '<hr />';
    }

    return $output;
  }

  private function generateStatsResourceUsage()
  {
    $output = '';
    $output .= '<table style="color:#333"><tr>';
    $output .= '<td>Elapsed Test Time:</td>';
    $output .= '<td>' . $this->elapsedTestTime . '</td>';
    $output .= '</tr><tr><td>Memory Usage:</td>';
    $output .= '<td>' . $this->formatBytes($this->memoryUsage) . '</td>';
    $output .= '</tr><tr><td>Peak Memory Usage:</td>';
    $output .= '<td>' . $this->formatBytes($this->peakMemoryUsage) . '</td>';
    $output .= '</tr><tr><td>Used Configs:</td>';
    $output .= '<td>' . $this->generateConfigsString() . '</td>';
    $output .= '</tr></table>';
    $output .= '<hr /><br /><br />';

    return $output;
  }

  private function generateConfigsString()
  {
    $errorReportingStatus = ($this->errorReporting) ? "enabled" : "disabled";
    $debuggingStatus = ($this->debugging) ? "enabled" : "disabled";
    $maxExecutionTime = ($this->maxExecutionTime != 0) ?
      $this->maxExecutionTime . 's' : 'unlimited';

    $output = '';
    $output .= '( Max Execution Time: ' . $maxExecutionTime . ' - ';
    $output .= 'Memory Limit: ' . $this->memoryLimit . ' - ';
    $output .= 'Error Reporting: ' . $errorReportingStatus . ' - ';
    $output .= 'Debugging: ' . $debuggingStatus . ' )';

    return $output;
  }

  private function formatBytes($bytes, $precision = 2)
  {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
     $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
  }

  private function calcElapsedTime($startTime)
  {
    // Get the difference between start and end in microseconds,as a float value
    $diff = microtime(true) - $startTime;

    // Break the difference into seconds and microseconds
    $sec = intval($diff);
    $micro = $diff - $sec;
    // Format the result as you want it
    // $final will contain something like "00:00:02.452"
    $final = strftime('%T', mktime(0, 0, $sec)) .
      str_replace('0.', '.', sprintf('%.3f', $micro));

    $this->elapsedTestTime =  $final;
  }

  private function calcMemoryUsage()
  {
    $this->memoryUsage = memory_get_usage();
    $this->peakMemoryUsage = memory_get_peak_usage();
  }
}

?>
