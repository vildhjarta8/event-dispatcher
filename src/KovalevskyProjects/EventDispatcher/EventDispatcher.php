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

    /**
     * Removes the action.
     *
     * @param string   $event  Event's name.
     * @param callable $action The function that will be removed.
     *
     * @api
     */
    public function off($event, Callable $action)
    {
        if (!$this->has($event, $action)) {
            return;
        }

        if (false === $key = array_search($action, $this->events[$event])) {
            return;
        }

        unset ($this->events[$event][$key]);
    }

    /**
     * Attaches the action for the more than one event.
     *
     * @param string|array $events The string with the names of the events,
     *                             separated by the "space" or an array.
     * @param callable     $action The action that will be called on the one
     *                             of this events.
     *
     * @throws \InvalidArgumentException
     * @api
     */
    public function bind($events, Callable $action = null)
    {
        if (is_string($events)) {
            $events = $this->toArray($events);
        }

        if (null === $action) {
            foreach ($events as $event => $action) {
                if (!is_callable($action)) {
                    throw new \InvalidArgumentException(
                        'Action is must be callable'
                    );
                }

                $this->on($event, $action);
            }

            return;
        }

        foreach ($events as $event) {
            $this->on($event, $action);
        }
    }

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
    public function unbind($events = null)
    {
        if (null === $events) {
            $this->events = array();
            return;
        }

        if (is_string($events)) {
            $events = $this->toArray($events);
        }

        foreach ($events as $event) {
            unset ($this->events[$event]);
        }
    }

    /**
     * Checks whether the specified event has action.
     *
     * @param string   $event  Event's name
     * @param callable $action Optional action.
     *
     * @return bool
     * @api
     */
    public function has($event, Callable $action = null)
    {
        if ($action === null) {
            return (isset($this->events[$event]));
        }

        return (false !== array_search($action, $this->events[$event]));
    }

    protected function toArray($events)
    {
        return preg_split('/[\s]+/', $events);
    }
}