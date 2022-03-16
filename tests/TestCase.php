<?php

namespace Tests;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function setup(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function create_user($args = [], $num = 1)
    {
        return UserFactory::new()->count($num)->create($args);
    }
}
