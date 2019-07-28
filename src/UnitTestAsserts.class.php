<?php

namespace Alimodev;

require_once('UnitTest.class.php');

class UnitTestAsserts extends UnitTest
{
  /**
   * properties
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
    $this->checkAssertStackIsOk();
    $currentAssert = $this->calledAssertsStack[$testId];
    $assertFuncName = array_keys($currentAssert)[0];
    $assertFuncArgs = $currentAssert[$assertFuncName];
    $testNameWithAssertName = $formattedTestName . ' [ ' . $assertFuncName . ' ] ';

    // running the assert function with it's args and the test result
    $assertNameWithNameSpace = 'Alimodev\\' . $assertFuncName;
    $assertInstance = new $assertNameWithNameSpace();
    $assertResult = $assertInstance->getResult($runResult, ...$assertFuncArgs);
    if ($assertResult)
    {
      $this->passedTests[$testNameWithAssertName] = $runResult;
    } else {
      $this->failedTests[$testNameWithAssertName] = $runResult;
    }
  }

  private function checkAssertStackIsOk()
  {
    if (
      !empty($this->calledAssertsStack) &&
      (count($this->calledAssertsStack) == count($this->testFunctions))
      )
    {
      return true;
    }
    die('There is a problem in your asserts!');
  }

}

?>
