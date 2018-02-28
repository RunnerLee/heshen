<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen;

use Runner\Heshen\Contracts\StatefulInterface;

class Transition
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var State
     */
    protected $fromState;

    /**
     * @var State
     */
    protected $toState;

    /**
     * @var null|callable
     */
    protected $checker;

    /**
     * Transition constructor.
     *
     * @param string $name
     * @param State  $from
     * @param State  $to
     * @param null   $checker
     */
    public function __construct(string $name, State $from, State $to, $checker = null)
    {
        $this->name = $name;
        $this->fromState = $from;
        $this->toState = $to;
        $this->checker = $checker;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return State
     */
    public function getFromState(): State
    {
        return $this->fromState;
    }

    /**
     * @return State
     */
    public function getToState(): State
    {
        return $this->toState;
    }

    /**
     * @return callable|null
     */
    public function getChecker()
    {
        return $this->checker;
    }

    /**
     * @param StatefulInterface $stateful
     * @param array             $parameters
     *
     * @return bool
     */
    public function can(StatefulInterface $stateful, array $parameters = []): bool
    {
        if ($stateful->getState() !== $this->fromState->getName()) {
            return false;
        }

        if (!is_null($this->checker) && !(bool)call_user_func_array($this->checker, [$stateful, $parameters])) {
            return false;
        }

        return true;
    }
}
