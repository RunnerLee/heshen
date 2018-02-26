<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen\Testing;

use Runner\Heshen\Contracts\StatefulInterface;
use Runner\Heshen\State;
use Runner\Heshen\Transition;

class TransitionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetState()
    {
        $transition = new Transition(
            'one',
            new State('a', State::TYPE_INITIAL),
            new State('b', State::TYPE_NORMAL)
        );
        $this->assertSame('a', $transition->getFromState()->getName());
        $this->assertSame(true, $transition->getFromState()->isInitial());
        $this->assertSame('b', $transition->getToState()->getName());
        $this->assertSame(true, $transition->getToState()->isNormal());
    }

    public function testCan()
    {
        $transition = new Transition(
            'one',
            new State('a', State::TYPE_INITIAL),
            new State('b', State::TYPE_NORMAL)
        );

        $stateful = new class() implements StatefulInterface {
            protected $state = 'a';

            public function getState(): string
            {
                return $this->state;
            }

            public function setState(string $state): void
            {
                $this->state = $state;
            }
        };

        $this->assertSame(true, $transition->can($stateful));
        $stateful->setState('b');
        $this->assertSame(false, $transition->can($stateful));
        $stateful->setState('a');

        $transition = new Transition(
            'one',
            new State('a', State::TYPE_INITIAL),
            new State('b', State::TYPE_NORMAL),
            function (StatefulInterface $stateful, array $parameters) {
                if (!isset($parameters['random'])) {
                    return false;
                }

                return $parameters['random'] > 5;
            }
        );

        $this->assertSame(false, $transition->can($stateful));
        $this->assertSame(false, $transition->can($stateful, [
            'random' => 4,
        ]));
        $this->assertSame(true, $transition->can($stateful, [
            'random' => 6,
        ]));
    }
}
