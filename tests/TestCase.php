<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Snapshots\MatchesSnapshots;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MatchesSnapshots;
    protected function setUp(): void
    {
        if (!defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }

        parent::setUp();

        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }
}
