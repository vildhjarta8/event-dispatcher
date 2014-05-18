EventDispatcher
===============
Simple PHP library that allow you to dispatch events in your system.

Usage
=====
Here's the simple example of the usage:

```php
<?php

$dispatcher = new \KovalevskyProjects\EventDispatcher\EventDispatcher();

$dispatcher->on('hello.world', function() {
  echo 'Hello World!';
});

$dispatcher->trigger('hello.world');
```

Also you can use event parameters. It can be single parameter or an array of the parameters:
```php
<?php

$dispatcher->on('hello.world', function($text) {
  echo $text;
});

$dispatcher->on('foo.bar', function($foo, $bar) {
  echo $foo + $bar;
});

$dispatcher->trigger('hello.world', 'Hello World!');

// You can use simple numeric arrays instead of associative
$dispatcher->trigger('foo.bar', array(
  'foo' => 2,
  'bar' => 2,
));
```
