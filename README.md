EventDispatcher
===============
Simple PHP library that allow you to dispatch events in your system.

Installation
============
Install it via [Composer](https://getcomposer.org/) (```kovalevsky-projects/event-dispatcher``` on [Packagist](https://packagist.org/packages/kovalevsky-projects/event-dispatcher))


Usage
=====
Here's the simple example of the usage:

```php
$dispatcher = new \KovalevskyProjects\EventDispatcher\EventDispatcher();

$dispatcher->on('hello.world', function() {
  echo 'Hello World!';
});

$dispatcher->trigger('hello.world');
```

Also you can use event parameters. It can be single parameter or an array of the parameters:
```php
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

API
===
### Trigger
```trigger($event, $parameters = null)``` - Dispatches the specified event.

You can specify single parameter or an array of parameters as second argument:
```php
$dispatcher->trigger('foo.bar', 'some parameter');
// or
$dispatcher->trigger('foo.bar', [
  'one' => 'parameter one',
  'two' => 'parameter two',
]);
```

### On
```on($event, $action)``` - Adds the action for the event.

```php
$dispatcher->on('post.update', function($post, $author) {
  notify('The post ' . $post->title . ' updated by the ' . $author);
});
```

### Off
```off($event, $action)``` - Removes the action.

```php
$dispatcher->on('some.action', $callableFunction);
// ...
$dispatcher->off('some.action', $callableFunction);
```

Please note: If your are using the closures, then you can't remove the action using ```Off()``` method.

### Bind
```bind($events, $action = null)``` - Attaches the action for the more than one event.

```php
$dispatcher->bind('foo bar baz', function() {
  echo 'You will see this message when foo, bar and baz events will be triggered';
});

// or with array

$dispatcher->bind(['foo', 'bar', 'baz'], function() { ... });

// or you can specify different actions for the each event

$dispatcher->bind([
  'foo' => function() { ... },
  'bar' => function() { ... },
  'baz' => function() { ... },
]);
```

### Unbind
```unbind($events = null)``` - Removes all previously attached actions.

```php
$dispatcher->unbind('foo bar baz');
// or
$dispatcher->unbind(['foo', 'bar', 'baz']);
// or you can remove ALL actions.
$dispatcher->unbind();
```

### Has
```has($event, $action = null)``` - Checks whether the specified event has action.

```php
$dispatcher->has('foo');
// or you can check for the specific action
$dispatcher->has('foo', $someAction);
```
