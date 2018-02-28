<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen\Testing;

use Runner\Heshen\Blueprint;
use Runner\Heshen\Contracts\StatefulInterface;
use Runner\Heshen\Machine;
use Runner\Heshen\State;

class MachineTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Machine
     */
    protected $machine;

    protected $object;

    /**
     *
     */
    public function setUp()
    {
        $stateful = new class implements StatefulInterface {

            protected $state = 'a';

            protected $demo = 1;

            public function getState(): string
            {
                return $this->state;
            }

            public function setState(string $state): void
            {
                $this->state = $state;
            }

            public function addDemo($number)
            {
                $this->demo += $number;
            }

            public function getDemo()
            {
                return $this->demo;
            }
        };

        $blueprint = new class extends Blueprint {

            protected function configure(): void
            {
                $this->addState('a', State::TYPE_INITIAL);
                $this->addState('b', State::TYPE_NORMAL);
                $this->addState('c', State::TYPE_FINAL);
                $this->addState('d', State::TYPE_FINAL);

                $this->addTransition('one', 'a', 'b');
                $this->addTransition('two', 'b', 'c');
                $this->addTransition('three', 'c', 'd');
            }

            protected function preOne(StatefulInterface $stateful, array $parameters)
            {
                $stateful->addDemo(1);
            }
            protected function postOne(StatefulInterface $stateful, array $parameters)
            {
                $stateful->addDemo(2);
            }
        };

        $this->machine = new Machine($stateful, $blueprint);
        $this->object = $stateful;
    }

    public function testGetCurrentState()
    {
        $this->assertSame('a', $this->machine->getCurrentState());
    }

    public function testCan()
    {
        $this->assertSame(true, $this->machine->can('one'));
        $this->assertSame(false, $this->machine->can('two'));
        $this->assertSame(false, $this->machine->can('three'));
    }

    public function testApply()
    {
        $this->machine->apply('one');
        $this->assertSame('b', $this->machine->getCurrentState());
        $this->assertSame(false, $this->machine->can('one'));
        $this->assertSame(true, $this->machine->can('two'));
        $this->assertSame(false, $this->machine->can('three'));

        $this>self::assertSame(4, $this->object->getDemo());
    }
}
