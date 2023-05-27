<?php

namespace Tests\Unit\Models;

use App\Models\Agency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgencyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_create_an_agency(): void
    {
        $name = 'Sunday';
        $email = 'teamsunday@gmail.com';

        $agency = Agency::create([
            'name' => $name,
            'email' => $email
        ]);

        $this->assertSame($name, $agency->name);
        $this->assertSame($email, $agency->email);
    }
}
