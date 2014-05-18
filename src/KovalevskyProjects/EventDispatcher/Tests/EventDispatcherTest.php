<?php

namespace KovalevskyProjects\EventDispatcher\Tests;


use KovalevskyProjects\EventDispatcher\EventDispatcher;

class EventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testOn()
    {
        $dispatcher = new EventDispatcher();

        $this->assertFalse($dispatcher->has('foo'));

        $dispatcher->on('foo', function() {
            return;
        });

        $this->assertTrue($dispatcher->has('foo'));
    }

    public function testOff()
    {
        $dispatcher = new EventDispatcher();
        $action = function() {
            return;
        };

        $this->assertFalse($dispatcher->has('foo'));

        $dispatcher->on('foo', $action);
        $this->assertTrue($dispatcher->has('foo'));

        $dispatcher->off('foo', $action);
        $this->assertFalse($dispatcher->has('foo', $action));
    }

    public function testBindFromString()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->bind('foo baz', function() {
            return;
        });

        $actual = array(
            $dispatcher->has('foo'),
            $dispatcher->has('bar'),
            $dispatcher->has('baz'),
        );

        $expected = array(
            true, false, true
        );

        $this->assertSame($expected, $actual);
    }

    public function testBindFromArray()
    {
        $dispatcher = new EventDispatcher();
        $action = function() {
            return;
        };

        $dispatcher->bind(array(
            'foo' => $action,
            'baz' => $action,
        ));

        $actual = array(
            $dispatcher->has('foo'),
            $dispatcher->has('bar'),
            $dispatcher->has('baz'),
        );

        $expected = array(
            true, false, true
        );

        $this->assertSame($expected, $actual);
    }

    public function testUnbindAll()
    {
        $dispatcher = new EventDispatcher();
        $action = function() {
            return;
        };

        $dispatcher->bind(array(
            'foo' => $action,
            'baz' => $action,
        ));

        $dispatcher->on('bar', $action);

        $expected = array(true, true, true);
        $actual   = array(
            $dispatcher->has('foo'),
            $dispatcher->has('bar'),
            $dispatcher->has('baz'),
        );

        $this->assertSame($expected, $actual);

        $dispatcher->unbind();

        $expected = array(false, false, false);
        $actual   = array(
            $dispatcher->has('foo'),
            $dispatcher->has('bar'),
            $dispatcher->has('baz'),
        );

        $this->assertSame($expected, $actual);
    }

    public function testUnbindSpecific()
    {
        $dispatcher = new EventDispatcher();
        $action = function() {
            return;
        };

        $dispatcher->bind(array(
            'foo' => $action,
            'bar' => $action,
            'baz' => $action,
        ));

        $expected = array(true, true, true);
        $actual   = array(
            $dispatcher->has('foo'),
            $dispatcher->has('bar'),
            $dispatcher->has('baz'),
        );

        $this->assertSame($expected, $actual);

        $dispatcher->unbind('baz');

        $expected = array(true, true, false);
        $actual   = array(
            $dispatcher->has('foo'),
            $dispatcher->has('bar'),
            $dispatcher->has('baz'),
        );

        $this->assertSame($expected, $actual);

        $dispatcher->unbind(array(
            'bar', 'foo'
        ));

        $expected = array(false, false, false);
        $actual   = array(
            $dispatcher->has('foo'),
            $dispatcher->has('bar'),
            $dispatcher->has('baz'),
        );

        $this->assertSame($expected, $actual);
    }

    public function testHas()
    {
        $dispatcher = new EventDispatcher();

        $action1 = function() {
            return;
        };

        $action2 = function() {
            return;
        };

        $action3 = function() {
            return;
        };

        $this->assertFalse($dispatcher->has('foo'));

        $dispatcher->on('foo', $action1);
        $dispatcher->on('foo', $action2);

        $this->assertTrue($dispatcher->has('foo'));
        $this->assertTrue($dispatcher->has('foo', $action1));
        $this->assertTrue($dispatcher->has('foo', $action2));
        $this->assertFalse($dispatcher->has('foo', $action3));

        $dispatcher->off('foo', $action2);

        $this->assertFalse($dispatcher->has('foo', $action2));
    }
}