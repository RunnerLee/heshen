<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen;

use Runner\Heshen\Event\Event;
use Runner\Heshen\Support\StateEvents;
use Runner\Heshen\Exceptions\LogicException;
use Runner\Heshen\Contracts\StatefulInterface;
use Runner\Heshen\Exceptions\SetStateFailedException;

class Machine
{
    /**
     * @var StatefulInterface
     */
    protected $stateful;

    /**
     * @var Blueprint
     */
    protected $blueprint;

    /**
     * Machine constructor.
     *
     * @param StatefulInterface $stateful
     * @param Blueprint         $blueprint
     */
    public function __construct(StatefulInterface $stateful, Blueprint $blueprint)
    {
        $this->stateful = $stateful;
        $this->blueprint = $blueprint;
    }

    /**
     * @return string
     */
    public function getCurrentState(): string
    {
        return $this->stateful->getState();
    }

    /**
     * @param $transitionName
     * @param array $parameters
     *
     * @return bool
     */
    public function can($transitionName, array $parameters = []): bool
    {
        return $this
            ->blueprint
            ->getTransition($transitionName)
            ->can($this->stateful, $parameters);
    }

    /**
     * @param $transitionName
     * @param array $parameters
     */
    public function apply($transitionName, array $parameters = []): void
    {
        if (!$this->can($transitionName, $parameters)) {
            throw new LogicException(sprintf(
                'The "%s" transition can not be applied to the "%s" state of object "%s"',
                $transitionName,
                $this->stateful->getState(),
                get_class($this->stateful)
            ));
        }

        $this->dispatchEvent(StateEvents::PRE_TRANSITION . $transitionName, $parameters);

        $transition = $this->blueprint->getTransition($transitionName);

        $this->stateful->setState($transition->getToState()->getName());

        if ($this->stateful->getState() !== $transition->getToState()->getName()) {
            throw new SetStateFailedException(sprintf(
                'Failed to set the "%s" state for object "%s"',
                $transition->getToState()->getName(),
                get_class($this->stateful)
            ));
        }

        $this->dispatchEvent(StateEvents::POST_TRANSITION . $transitionName, $parameters);
    }

    /**
     * @return Blueprint
     */
    public function getBlueprint(): Blueprint
    {
        return $this->blueprint;
    }

    /**
     * @param $event
     * @param array $parameters
     */
    protected function dispatchEvent($event, array $parameters = []): void
    {
        $this->blueprint->getDispatcher()->dispatch($event, new Event($this->stateful, $parameters));
    }
}
