<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen;

use Runner\Heshen\Contracts\StatefulInterface;

class Factory
{
    /**
     * @var array
     */
    protected $loader = [];

    /**
     * @var Blueprint[]
     */
    protected $blueprints = [];

    /**
     * Factory constructor.
     * @param array $loader
     */
    public function __construct(array $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @param StatefulInterface $stateful
     * @return Machine
     */
    public function make(StatefulInterface $stateful): Machine
    {
        $blueprint = $this->loader[get_class($stateful)];

        if (!array_key_exists($blueprint, $this->blueprints)) {
            $this->blueprints[$blueprint] = new $blueprint;
        }

        return new Machine($stateful, $this->blueprints[$blueprint]);
    }
}
