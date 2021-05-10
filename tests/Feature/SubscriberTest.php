<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Url cannot be empty.
     *
     * @return void
     */
    public function test_url_cannot_be_empty()
    {
        $this->withExceptionHandling();
        $topic = Str::random(6);
        $response = $this->post('/subscribe/' . $topic, [
            'url' => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test Can Subscribe to Topic.
     *
     * @return void
     */
    public function test_url_must_be_valid()
    {
        $this->withExceptionHandling();
        $topic = Str::random(6);
        $response = $this->post('/subscribe/' . $topic, [
            'url' => 'www.wehook.com'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test Can Subscribe to Topic.
     *
     * @return void
     */
    public function test_can_subscribe_to_topic()
    {
        $this->withExceptionHandling();
        $topic = Str::random(6);
        $response = $this->post('/subscribe/' . $topic, [
            'url' => 'https://webhook.site/c3b5acb1-c06b-49ed-b5e1-4cb94543f3cd'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'topic',
                    'url'
                ]
            ]);
    }
}
