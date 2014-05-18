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

    /**
     * Removes the action.
     *
     * @param string   $event  Event's name.
     * @param callable $action The function that will be removed.
     *
     * @api
     */
    public function off($event, Callable $action);

    /**
     * Attaches the action for the more than one event.
     *
     * @param string|array $events The string with the names of the events,
     *                             separated by the "space" or an array.
     * @param callable     $action The action that will be called on the one
     *                             of this events.
     *
     * @api
     */
    public function bind($events, Callable $action = null);

    /**
     * Removes all previously attached actions.
     *
     * @param null|string|array $events The string with the names of the events,
     *                                  separated with "space" or an array with
     *                                  event names. NULL will remove all
     *                                  attached actions
     *
     * @api
     */
    public function unbind($events = null);

    /**
     * Checks whether the specified event has action.
     *
     * @param string   $event  Event's name
     * @param callable $action Optional action.
     *
     * @return bool
     * @api
     */
    public function has($event, Callable $action = null);
}