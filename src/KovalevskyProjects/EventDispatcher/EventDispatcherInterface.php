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
     * @param string       $event      Event's name.
     *
     * @param string|array $parameters Optional event's parameters.
     *
     * @api
     */
    public function trigger($event, $parameters = null);

    /**
     * Adds the action for the event.
     *
     * @param string   $event  Event's name.
     * @param callable $action The function that will be called on event.
     *
     * @return EventDispatcherInterface
     * @api
     */
    public function on($event, Callable $action);
}