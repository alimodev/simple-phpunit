<?php

// some delay and pass
function testFunc1()
{
  for($i=0;$i<3;$i++)
  {
    usleep(mt_rand(100,200)*1000);
  }
  return true;
}

// failed test
function testFunc2()
{
  return false;
}

// passed test
function testFunc3()
{
  return null;
}

// passed test with output
function testFunc4($name)
{
  echo 'Output Test ' . $name;
}

?>
