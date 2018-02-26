<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen;

use Runner\Heshen\Contracts\StatefulInterface;
use Runner\Heshen\Event\Event;
use Runner\Heshen\Exceptions\LogicException;
use Runner\Heshen\Support\StateEvents;

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

        $this->initial();
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

        $this->dispatchEvent(StateEvents::PRE_TRANSITION.$transitionName, $parameters);

        $transition = $this->blueprint->getTransition($transitionName);

        $this->stateful->setState($transition->getToState()->getName());

        $this->dispatchEvent(StateEvents::POST_TRANSITION.$transitionName, $parameters);
    }

    /**
     * @return void
     */
    protected function initial(): void
    {
        $state = $this->blueprint->getState($this->stateful->getState());

        if ($state->isInitial()) {
            $this->dispatchEvent(StateEvents::INITIAL);
        }
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
