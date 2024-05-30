<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * Test whether not sending a word in the body results in a 422 status code
     */
    public function test_status_code_on_missing_word_in_body(): void
    {
        $response = $this->post('/api/check');

        $response->assertStatus(422);
    }


    /**
     * Test whether an invalid word in the body results in a 422 status code
     */
    public function test_status_code_on_invalid_word_in_body(): void
    {
        $response = $this->post('/api/check', ['word' => 'abc']);

        $response->assertStatus(422);
    }


    /**
     * Test whether a valid word in the body results in a 200 status code
     */
    public function test_status_code_on_valid_word_in_body(): void
    {
        $response = $this->post('/api/check', ['word' => 'abide']);

        $response->assertStatus(200);
    }
}
