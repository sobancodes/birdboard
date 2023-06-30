<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null)
    {
        $createdUser = User::factory()->create();

        $user = $user ?: $createdUser;

        $this->be($user ?: $createdUser);

        return $user;
    }
}
