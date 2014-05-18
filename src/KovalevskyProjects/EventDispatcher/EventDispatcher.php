<?php

namespace KovalevskyProjects\EventDispatcher;

/**
 * Class EventDispatcher
 * @package KovalevskyProjects\EventDispatcher
 * @author  Artur Kovalevsky <kovalevskyproj@gmail.com>
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array
     */
    protected $events;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->events = array();
    }

    /**
     * Dispatches the specified event.
     *
     * @param string       $event      Event's name.
     *
     * @param string|array $parameters Optional event's parameters.
     *
     * @api
     */
    public function trigger($event, $parameters = null)
    {
        if (!isset($this->events[$event])) {
            return;
        }

        foreach ($this->events[$event] as $action)
        {
            call_user_func_array($action, (array) $parameters);
        }
    }

    /**
     * Adds the action for the event.
     *
     * @param string   $event  Event's name.
     * @param callable $action The function that will be called on event.
     *
     * @return EventDispatcher
     * @api
     */
    public function on($event, Callable $action)
    {
        $this->events[$event][] = $action;

        return $this;
    }
}