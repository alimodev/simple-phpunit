<?php

namespace Alimodev;

/**
 * َAutoloader
 * for Interfaces, Asserts
 */
spl_autoload_register(function($className){
	$className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
	foreach (glob(__DIR__ . '/*', GLOB_ONLYDIR) as $dir)
	{
		$classFile = "$dir/" . $className . '.php';
		if (file_exists($classFile))
		{
			require_once($classFile);
			break;
		}
	}
});

/**
 * Unit Testing Class
 * by ALireza Mortazavi
 * https://github.com/alimodev/
 */
class UnitTest
{
  /**
   * Properties
   */
  public $maxExecutionTime = 100; // in seconds, 0 for unlimited
  public $memoryLimit = '128M';
  public $errorReporting = true;
  public $debugging = false;

  private $testGroupName = '';
  private $elapsedTestTime = 0;
  private $memoryUsage = 0;
  private $peakMemoryUsage = 0;
  private $assertCondition = false;

  protected $testFunctions = array();
  protected $passedTests = array();
  protected $failedTests = array();

  /**
   * Constructor
   */

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
    $lastTestId = count($this->testFunctions)-1;
    $filteredTestIds = array();
    $filteredTestIds[] = array_keys($this->testFunctions)[$lastTestId];
    $this->filterAndRun($filteredTestIds);
  }

  public function runFirstTest()
  {
    $firstTestId = 0;
    $filteredTestIds = array();
    $filteredTestIds[] = array_keys($this->testFunctions)[$firstTestId];
    $this->filterAndRun($filteredTestIds);
  }

  public function runThisTest($testName)
  {
    $filteredTestIds = array();
    $filteredTestIds = $this->getTestArrayIdIfExists($testName);
    $this->filterAndRun($filteredTestIds);
  }

  public function addTestFunc($functionName, ...$functionArgs)
  {
    if (function_exists($functionName))
    {
      $this->testFunctions[] = array(
        $functionName => $functionArgs,
      );
    }
    return $this;
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
    return $this;
  }

  public function removeTestFunc($functionName)
  {
    $filteredTestIds = $this->getTestArrayIdIfExists($functionName);
    foreach ($filteredTestIds as $testId)
    {
      unset($this->testFunctions[$testId]);
    }
  }

  public function removeAllTests()
  {
    unset($this->testFunctions);
    unset($this->passedTests);
    unset($this->failedTests);
  }

  public function getTests()
  {
    return $this->testFunctions;
  }

  public function getPassedTests()
  {
    return $this->passedTests;
  }

  public function getFailedTests()
  {
    return $this->failedTests;
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

  public function getElapsedTestTime()
  {
    return $this->elapsedTestTime;
  }

  public function getMemoryUsage()
  {
    return $this->memoryUsage;
  }

  public function getPeakMemoryUsage()
  {
    return $this->peakMemoryUsage;
  }

  public function getTestGroupName()
  {
    return $this->testGroupName;
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
    foreach($testsToRun as $testId => $testFunc)
    {
      $testName = array_keys($testFunc)[0];
      $testArgs = $testFunc[$testName];
      $formattedTestName = $testName. $this->getFormattedArgs($testArgs);

      ob_start();
      $runResult = call_user_func($testName, ...$testArgs);
      $bufferedOutput = ob_get_contents();
      ob_end_clean();

      $this->printDebuggingInfo($formattedTestName, $bufferedOutput);
      $this->assert($formattedTestName, $testId, $runResult);
    }
  }

  protected function assert($formattedTestName, $testId, $runResult)
  {
    $testNameWithAssertName = $formattedTestName . ' [asserted not ' .
      ($this->assertCondition ? 'true' : 'false') . '] ';
    if ($runResult === $this->assertCondition)
    {
      $this->failedTests[$testNameWithAssertName] = $runResult;
    } else {
      $this->passedTests[$testNameWithAssertName] = $runResult;
    }
  }

  private function getTestArrayIdIfExists($testName)
  {
    $filteredTestsIds = array();
    foreach ($this->getTests() as $testId => $testFunc)
    {
      if (strtolower($testName) == strtolower(array_keys($testFunc)[0]))
      {
        $filteredTestsIds[] = $testId;
      }
    }
    return $filteredTestsIds;
  }

  private function filterTests($testIds)
  {
    return array_filter($this->testFunctions,
      function($key) use($testIds){
        foreach ($testIds as $testId)
        {
          return $key == $testId;
        }
    }, ARRAY_FILTER_USE_KEY);
  }

  private function filterAndRun($filteredTestIds)
  {
    $filteredTests = $this->filterTests($filteredTestIds);
    $this->run($filteredTests);
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

  private function getFormattedArgs($args)
  {
    return '( ' . $this->formatArgs($args) . ' )';
  }

  private function formatArgs($args)
  {
    $formatted = '';
    foreach ($args as $arg)
    {
      $formatted .= print_r($arg, true);
      $formatted .= ', ';
    }
    return trim(trim($formatted), ',');
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
    $this->memoryUsage = $this->formatBytes(memory_get_usage());
    $this->peakMemoryUsage = $this->formatBytes(memory_get_peak_usage());
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

}

?>
