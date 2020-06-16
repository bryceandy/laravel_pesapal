<?php

namespace Bryceandy\Laravel_Pesapal\Tests;

use Bryceandy\Laravel_Pesapal\PesapalServiceProvider;
use Illuminate\Foundation\Application;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Base set up
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/../src/database/factories');
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testDb');
        $app['config']->set('database.connections.testDb', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PesapalServiceProvider::class,
        ];
    }
}
