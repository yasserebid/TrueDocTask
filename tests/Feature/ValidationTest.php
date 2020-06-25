<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRowValidation()
    {
        $response = $this->post('validate-row', [
            "first_name" => "ii",
            "second_name" => "",
            "family_name" => 'Ebid',
            "uid" => 123456,
        ]);

    
        $response->assertStatus(200);
    }
}
