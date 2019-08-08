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
     * @var State[]
     */
    protected $fromStates;

    /**
     * @var State
     */
    protected $toState;

    /**
     * @var callable|null
     */
    protected $checker;

    /**
     * Transition constructor.
     *
     * @param string      $name
     * @param array|State $from
     * @param State       $to
     * @param callable    $checker
     */
    public function __construct(string $name, $from, State $to, $checker = null)
    {
        $this->name = $name;
        $this->fromStates = !is_array($from) ? [$from] : $from;
        $this->toState = $to;
        $this->checker = $checker;
    }

    /**
     * @return State[]
     */
    public function getFromStates(): array
    {
        return $this->fromStates;
    }

    /**
     * @return State
     */
    public function getToState(): State
    {
        return $this->toState;
    }

    /**
     * @param StatefulInterface $stateful
     * @param array             $parameters
     *
     * @return bool
     */
    public function can(StatefulInterface $stateful, array $parameters = []): bool
    {
        foreach ($this->fromStates as $state) {
            if ($state->getName() === $stateful->getState()) {
                if (!is_null($this->checker) && !(bool) call_user_func($this->checker, $stateful, $parameters)) {
                    return false;
                }

                return true;
            }
        }

        return false;
    }
}
