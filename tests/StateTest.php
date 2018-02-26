<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen\Testing;

use Runner\Heshen\State;

class StateTest extends \PHPUnit_Framework_TestCase
{
    public function testIsInitial()
    {
        $state = new State('a', State::TYPE_INITIAL);
        $this->assertSame(true, $state->isInitial());
        $this->assertSame(false, $state->isNormal());
        $this->assertSame(false, $state->isFinal());
    }

    public function testIsNormal()
    {
        $state = new State('a', State::TYPE_NORMAL);
        $this->assertSame(false, $state->isInitial());
        $this->assertSame(true, $state->isNormal());
        $this->assertSame(false, $state->isFinal());
    }

    public function testIsFinal()
    {
        $state = new State('a', State::TYPE_FINAL);
        $this->assertSame(false, $state->isInitial());
        $this->assertSame(false, $state->isNormal());
        $this->assertSame(true, $state->isFinal());
    }
}
