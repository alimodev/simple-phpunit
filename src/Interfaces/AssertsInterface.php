<?php

interface AssertsInterface
{
  public function __construct();
  public function getResult($runResult, ...$assertFuncArgs);
}
