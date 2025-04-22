<?php

namespace Tests;

use Tests\Feature\Http\Controllers\Helpers\Dummy;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected Dummy $dummy;

    protected function setUp(): void {
        parent::setUp();
        $this->dummy = new Dummy();
    }
}
