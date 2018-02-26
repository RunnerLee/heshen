<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen\Contracts;

interface StatefulInterface
{
    public function getState(): string;

    public function setState(string $state): void;
}
