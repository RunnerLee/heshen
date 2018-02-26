<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen\Event;

use Runner\Heshen\Contracts\StatefulInterface;
use Symfony\Component\EventDispatcher\Event as BaseEvent;

class Event extends BaseEvent
{

    /**
     * @var StatefulInterface
     */
    protected $stateful;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Event constructor.
     * @param StatefulInterface $stateful
     * @param array $parameters
     */
    public function __construct(StatefulInterface $stateful, array $parameters = [])
    {
        $this->stateful = $stateful;
    }

    /**
     * @return StatefulInterface
     */
    public function getStateful(): StatefulInterface
    {
        return $this->stateful;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
