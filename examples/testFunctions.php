<?php

function testThatReturnsTrue()
{
  // some tests to do and finally:
  return true;
}

function testThatReturnsFalse()
{
  // some tests to do and finally:
  return false;
}

function testThatReturnsNull()
{
  // some tests to do and finally:
  return null;
}

function testThatReturnsString()
{
  // some tests to do and finally:
  return 'Hello World!';
}

function testThatReturnsNumber()
{
  // some tests to do and finally:
  $daysInTheWeek = 7;
  return $daysInTheWeek;
}

function testWithInputArgs($name = 'Someone')
{
  // some tests to do and finally:
  echo 'Hello ' . $name . '!';
}

function timelyTestThatReturnsTrue()
{
  // some tests to do and finally:
  usleep(mt_rand(300,600)*1000);
  return true;
}

?>
