# Heshen 有限状态机

> 年轻的樵夫哟，你掉的是这个金斧头，还是这个银斧头呢?

### Usage
```php
<?php

use Runner\Heshen\Blueprint;
use Runner\Heshen\State;
use Runner\Heshen\Contracts\StatefulInterface;
use Runner\Heshen\Factory;

class Demo extends Blueprint {
    protected function configure(): void
    {
        $this->addState('a', State::TYPE_INITIAL);
        $this->addState('b', State::TYPE_NORMAL);
        $this->addState('c', State::TYPE_NORMAL);
        $this->addState('d', State::TYPE_FINAL);

        $this->addTransition('one', 'a', 'b', function (StatefulInterface $stateful, array $parameters = []) {
            return true;
        });
        $this->addTransition('two', 'b', 'c');
    }

    public function preOne(StatefulInterface $stateful, array $parameters = [])
    {
        echo "\nhello world \n";
    }
}

class Model implements StatefulInterface {

    protected $state = 'a';

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        echo "\nsetting\n";
        $this->state = $state;
    }
}

$factory = new Factory([
    Model::class => Demo::class,
]);

$machine = $factory->make(new Model());


var_dump($machine->can('one')); // output: bool(true)
var_dump($machine->can('two')); // output: bool(false)
```