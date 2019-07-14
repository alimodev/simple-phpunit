# PHP Unit Test Class

A simple class for unit testing in your PHP applications.

This simple and tiny library lets you add unit tests to your projects. This is usually done in a separate 'tests' folder inside your application where you store all your test functions and the UnitTest Class itself. From there you can run your tests and see the stats. Which tests fail and which tests pass..

## Getting Started

To get started, see the examples in test.php
All you have to do is to create an instance of the class and start adding tests!

#### To Create an Instance:
```php
require_once('UnitTest.class.php');
$unit = new UnitTest();
```

## Adding the tests

To add the test, use the addTestFunc($functionName, ...$functionArgs) method, and add as many functions as you want, one by one.
```php
$unit->addTestFunc('testFunc1');
$unit->addTestFunc('testFunc2', 'arg1', 'arg2');
```

## Running the Tests

To run the tests, simply execute the run() method.
```php
$unit->run();
```
> `All test that don't return false are considered passed tests!`

## The Test Result

After running the tests, you can see a summary of the successful and failed tests, along with other useful information like the elapsed time, average and peak memory usage and ..
```php
$unit->printStats();
```

## Going Further

This class has lots of other useful public methods. You can explore them in the class itself!

## Authors

* **Alireza Mortazavi**
