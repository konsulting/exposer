# Exposer

## Installation
Install via Composer:
```
 $ composer require konsulting/exposer
```

## Usage
Consider the following class:
```php
<?php

class ClassUnderTest
{
    protected $secret = 'My secret';
    
    protected static $anotherSecret = 'My static secret';
    
    protected function add($number1, $number2)
    {
        return $number1 + $number2;
    }
    
    protected static function multiply($number1, $number2)
    {
        return $number1 * $number2;
    }
}
```

There are multiple ways to test the protected methods and properties on this class.

### Base Exposer
The most direct way is with the `BaseExposer` class. 
The subject must be passed into each method, and may be either an instance or the (string) class name.

```php
<?php

use Konsulting\Exposer\BaseExposer;

// With an instance
BaseExposer::hasMethod(new ClassUnderTest, 'add');                          // true
BaseExposer::invokeMethod(new ClassUnderTest, 'add', [1, 1]);               // 2
BaseExposer::getProperty(new ClassUnderTest, 'secret');                     // 'My secret'

// Static context
BaseExposer::hasMethod(ClassUnderTest::class, 'multiply');                  // true
BaseExposer::invokeStaticMethod(ClassUnderTest::class, 'multiply', [2,2]);  // 4
BaseExposer::getProperty(ClassUnderTest::class, 'anotherSecret');           // 'My static secret'
```

### Exposer
The `Exposer` class allows the use of a class's inaccessible methods and properties as if they were public.

```php
<?php

use Konsulting\Exposer\Exposer;

$exposer = Exposer::make(new ClassUnderTest);

$exposer->add(1, 1);                                // 2
$exposer->multiply(2, 2);                           // 4
$exposer->secret;                                   // 'My secret'
$exposer->anotherSecret;                            // 'My static secret'

// These methods are also available
$exposer->hasMethod('add');                          // true
$exposer->invokeMethod('add', [1, 1]);               // 2
$exposer->getProperty('secret');                     // 'My secret'
```

**Note:** Static methods and properties are available from an instance context, but of course non-static methods and properties are not available from a static context.

### Static Exposer
In a similar way, the `StaticExposer` class allows access to a class's static methods and properties without the need to provide an instance.
The target class name is set via the `setClass()` static method.

***Note:*** Because there is no `__getStatic()` method in PHP, only methods may be accessed magically.
Properties must be accessed with the `getProperty()` method.
```php
<?php

use Konsulting\Exposer\StaticExposer;

StaticExposer::setClass(ClassUnderTest::class);

StaticExposer::multiply(2, 2);                           // 4

// These methods are also available
StaticExposer::hasMethod('multiply');                      // true
StaticExposer::invokeMethod('multiply', [2, 2]);          // 4
StaticExposer::getProperty('anotherSecret');              // 'My static secret'
```
