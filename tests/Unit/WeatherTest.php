<?php

namespace Tests\Unit;

use App\Weather;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        Cache::clearResolvedInstances();
    } 

    public function test_example(): void
    {
        $mock = \Mockery::mock(Repository::class);
        $mock->shouldReceive('get')
        ->with('weather')
        ->once()
        ->andReturn(null);
        $weather = new Weather($mock);
        $this->assertTrue($weather->isSunnyTomorrow());
    }


    public function test_example_false(): void
    {
        $mock = \Mockery::mock(Repository::class);
        $mock->shouldReceive('get')
        ->with('weather')
        ->once()
        ->andReturn(false);
        $weather = new Weather($mock);
        $this->assertFalse($weather->isSunnyTomorrow());
    }
}
