<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen\Testing;

use Runner\Heshen\Support\Str;

class StrTest extends \PHPUnit_Framework_TestCase
{

    public function testStudly()
    {
        $this->assertSame('prePost', Str::studly('pre_post'));
        $this->assertSame('prePost', Str::studly('pre-post'));
        $this->assertSame('prePost', Str::studly('pre post'));
        $this->assertSame('prePost', Str::studly('prePost'));
    }
}
