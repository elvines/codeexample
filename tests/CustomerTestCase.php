<?php

namespace Tests;

abstract class CustomerTestCase extends TestCase
{
    protected static $isSeeded = false;

    public function setUp()
    {
        parent::setUp();

        /**
         * Autoseed in test database only once.
         */
        if (!self::$isSeeded) {
            $this->artisan("db:seed");
            self::$isSeeded = true;
        }
    }
}