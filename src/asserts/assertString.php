<?php

class assertString implements AssertsInterface
{
  /**
   * Object Decleration
   */
   private $assertion;

  /**
   * Public Methods
   */
   public function __construct()
   {
     $this->assertion = false;
   }

   public function getResult($runResult, ...$assertFuncArgs)
   {
     $this->doAssertion($runResult, ...$assertFuncArgs);
     return $this->assertion;
   }

  /**
   * Private Methods
   */
   private function doAssertion($runResult, ...$assertFuncArgs)
   {
     $this->assertion = is_string($runResult);
   }

}

?>
