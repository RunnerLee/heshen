<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen\Testing;

use Runner\Heshen\Blueprint;
use Runner\Heshen\State;

class BlueprintTest extends \PHPUnit_Framework_TestCase
{

    protected $blueprint;

    public function setUp()
    {
        $this->blueprint = new class extends Blueprint {
            protected function configure(): void
            {
                $this->addState('a', State::TYPE_INITIAL);
                $this->addState('b', State::TYPE_NORMAL);
                $this->addState('c', State::TYPE_FINAL);

                $this->addTransition('one', 'a', 'b');
                $this->addTransition('two', 'b', 'c');
                $this->addTransition('three', 'c', 'd');
            }

            protected function initial()
            {

            }
        };
    }

    public function testGetTransition()
    {

    }

    public function testGetState()
    {

    }

    public function testGetDispatcher()
    {

    }
}
