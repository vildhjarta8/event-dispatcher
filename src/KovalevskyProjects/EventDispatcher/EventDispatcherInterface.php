<?php

namespace KovalevskyProjects\EventDispatcher;

/**
 * Interface EventDispatcherInterface
 * @package KovalevskyProjects\EventDispatcher
 * @author  Artur Kovalevsky <kovalevskyproj@gmail.com>
 */
interface EventDispatcherInterface
{
    /**
     * Dispatches the specified event.
     *
     * @param string $event Event's name.
     *
     * @api
     */
    public function trigger($event);

    /**
     * Adds the action for the event.
     *
     * @param string   $event  Event's name.
     * @param callable $action The function that will be called on event.
     *
     * @api
     */
    public function on($event, Callable $action);
}