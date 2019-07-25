# PHP Unit Test Library

A simple class for unit testing in your PHP applications.

This simple library lets you add unit tests to your PHP projects. This is usually done in a separate 'tests' folder inside your application where you store all your test functions and the UnitTest Class itself. From there you can run your tests and see the stats Which tests fail and which ones pass, along with other usefull and debugging informations.

## Getting Started

To get started, you can see the examples. It's the best way to see how to start using this library. There are links to each example in the 'index.php' file, on the root of the project.
Long story short, all you have to do is to create an instance of the class and start adding tests!

#### To Create an Instance:
```php
require_once('UnitTest.class.php');
$unit = new UnitTest();
```

## Adding the tests

To add the tests, use the addTestFunc($functionName, ...$functionArgs) method, and add as many test functions as you want, one by one.
```php
$unit->addTestFunc('testFunc1');
$unit->addTestFunc('testFunc2', 'arg1', 'arg2');
```

#### Adding Tests with Patterns

You can add tests with pattern using the addTestFuncsWithPattern() method.
```PHP
$unit->addTestFuncsWithPattern('testThat*');
$unit->addTestFuncsWithPattern('testWith*', 'Arg1');
```

## Running the Tests

To run the tests, simply execute the run() method.
```php
$unit->run();
```
> `All tests that don't return false are considered passed tests!`

## The Test Result

After running the tests, you can see a summary of the successful and failed tests, along with other useful informations like the elapsed test time, average and peak memory usage and so on..
```php
$unit->printStats();
```

## Using Asserts

You can use asserts if you need more control over how you want to evaluate the test results. For Using asserts, you have to include 'UnitTestAsserts.class.php' file.
```PHP
$unit->addTestFunc('testThatReturnsTrue')->assertTrue();
$unit->addTestFunc('testThatReturnsFalse')->assertFalse();
$unit->addTestFunc('testThatReturnsNull')->assertNull();
```
> There are more assert methods in the asserts folder inside src. See the corresponding example for more information.

## Going Further

This library has lots of other useful public methods. You can explore them yourself or see the examples to get the hang of them!

#### Examples:

Here is the list of all the examples you can find in the project:
* Essential Usage
* Basic Usage
* Run Specific Test
* Change Configs
* Multiple Instances
* Add Test Functions with Pattern
* JSON Report
* Working with Asserts

## Authors

* **Alireza Mortazavi**
