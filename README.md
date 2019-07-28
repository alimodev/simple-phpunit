# PHP Unit Test Library

A simple class for unit testing in your PHP applications.

This simple library lets you add unit tests to your PHP projects very easily. This is usually done in a separate 'tests' folder inside your application, where you store all your test functions and the UnitTest Class itself. From there, you can run your tests and see the stats. Which tests fail and which ones pass, along with other usefull and debugging informations.

## Getting Started

To get started, you can see the examples. It's the best way to start using this library. There are links to each example in the 'index.php' file, at the root of the project. You can copy the examples and start thinkering with them.
Long story short, all you have to do is to include the 'loader.php' and create an instance of the class. Then you can start adding tests!

#### To Create an Instance:
```php
require_once('path/to/src/loader.php');
$unit = new Alimodev\UnitTest();
```

## Adding the Tests

To add the tests, use the addTestFunc($functionName, ...$functionArgs) method and add as many test functions as you want, one by one.
```php
$unit->addTestFunc('testFunc1');
$unit->addTestFunc('testFunc2', 'arg1', 'arg2');
```

#### Adding Tests with Patterns

You can add tests with pattern using the addTestFuncsWithPattern() method. The * works as the wildcard for matching test function names.
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

After running the tests, you can render multiple reports in different formats suitable for web, REST Api or even command line interface (CLI)! To see a summary of the successful and failed tests, along with other useful informations like the elapsed test time, average and peak memory usage,.. you can use the printStats() method of the static Report classes. You inject your UnitTest instance to these Report classes before using their print or fetch methods:
```php
Alimodev\ReportWeb::setInstance($unit);
Alimodev\ReportWeb::printSummary();
Alimodev\ReportWeb::printTests();
Alimodev\ReportWeb::printStats();
```

##### Available Report Formats
* WEB (Alimodev\ReportWeb)
* JSON (Alimodev\ReportJson)
* CLI (Alimodev\ReportCli)

## Using Asserts

You can use asserts if you need more control over how you want to evaluate the test results. For Using asserts, you have to create an instance of 'Alimodev\UnitTestAsserts()'.
```PHP
$unit = new Alimodev\UnitTestAsserts();

$unit->addTestFunc('testThatReturnsTrue')->assertTrue();
$unit->addTestFunc('testThatReturnsFalse')->assertFalse();
$unit->addTestFunc('testThatReturnsNull')->assertNull();
```
> There are more assert methods in the asserts folder inside src. See the corresponding example for more information.

## Going Further

This library has lots of other useful public methods. You can explore them yourself or see the examples to get the hang of them!

#### Examples:

Here is the list of all the examples you can find in the project:
1. Essential Usage
2. Basic Usage
3. Run Specific Test
4. Change Configs
5. Multiple Instances
6. Add Test Functions with Pattern
7. JSON Report
8. Working with Asserts
9. Running Tests from CLI

## Authors

* **Alireza Mortazavi**
