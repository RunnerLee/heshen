<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen\Testing\Fixture;

use Runner\Heshen\Contracts\StatefulInterface;

class AlphaStateful implements StatefulInterface
{
    public function getState(): string
    {
    }

    public function setState(string $state): void
    {
        // TODO: Implement setState() method.
    }
}
