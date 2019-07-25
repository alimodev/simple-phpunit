<?php

spl_autoload_register(function($class){
	$classPath = str_replace('\\', '/', $class);
	include __DIR__ . '/asserts/' . $classPath . '.php';
});

require_once('UnitTest.class.php');

class UnitTestAsserts extends UnitTest
{
  /**
   * Object Decleration
   */
  private $calledAssertsStack = array();

  /**
   * Public Methods
   */
  public function __call(string $name, array $arguments)
  {
    $this->updateAssertsStack($name, $arguments);
  }

  public function getAssertsStack()
  {
    return $this->calledAssertsStack;
  }

  /**
   * Private Methods
   */
  private function updateAssertsStack($name, $arguments)
  {
    $stackAndTestsDiff = $this->getStackAndTestsDiff();
    if ($stackAndTestsDiff > 0)
    {
      while ($stackAndTestsDiff > 0)
      {
        $this->calledAssertsStack[] = array(
          $name => $arguments,
        );
        $stackAndTestsDiff--;
      }
    }
  }

  private function getStackAndTestsDiff()
  {
    $countTestFuncs = count($this->getTests());
    $countAssertsStack = count($this->calledAssertsStack);
    $stackAndTestsDiff = $countTestFuncs - $countAssertsStack;
    return $stackAndTestsDiff;
  }

  protected function assert($formattedTestName, $testId, $runResult)
  {
    $currentAssert = $this->calledAssertsStack[$testId];
    $assertFuncName = array_keys($currentAssert)[0];
    $assertFuncArgs = $currentAssert[$assertFuncName];
    $testNameWithAssertName = $formattedTestName . ' [ ' . $assertFuncName . ' ] ';

    // running the assert function with it's args and the test result
    $assertInstance = new $assertFuncName();
    $assertResult = $assertInstance->getResult($runResult, ...$assertFuncArgs);
    if ($assertResult)
    {
      $this->passedTests[$testNameWithAssertName] = $runResult;
    } else {
      $this->failedTests[$testNameWithAssertName] = $runResult;
    }
  }

}

?>