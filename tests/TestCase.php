<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static $isMigrated = false;


    public function setUp() {
        parent::setUp();

        /**
         * Flush previous database changes and auto migrate our testing database only once.
         */
        if (!self::$isMigrated) {
            $this->artisan("migrate:refresh");
            self::$isMigrated = true;
        }
    }
}
