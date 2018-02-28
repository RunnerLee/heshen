<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */
namespace Runner\Heshen\Testing;

require __DIR__ . '/Fixture/AlphaBlueprint.php';
require __DIR__ . '/Fixture/BetaBlueprint.php';
require __DIR__ . '/Fixture/AlphaStateful.php';
require __DIR__ . '/Fixture/BetaStateful.php';

use Runner\Heshen\Factory;
use Runner\Heshen\Testing\Fixture\AlphaBlueprint;
use Runner\Heshen\Testing\Fixture\AlphaStateful;
use Runner\Heshen\Testing\Fixture\BetaBlueprint;
use Runner\Heshen\Testing\Fixture\BetaStateful;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testMake()
    {
        $factory = new Factory([
            AlphaStateful::class => AlphaBlueprint::class,
            BetaStateful::class => BetaBlueprint::class,
        ]);

        $this->assertSame(
            AlphaBlueprint::class,
            get_class($factory->make(new AlphaStateful())->getBlueprint())
        );
        $this->assertSame(
            BetaBlueprint::class,
            get_class($factory->make(new BetaStateful())->getBlueprint())
        );
    }

}
