<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test Can Subscribe to Topic.
     *
     * @return void
     */
    public function test_can_subscribe_to_topic()
    {
        $this->withExceptionHandling();
        $topic = Str::random(6);
        $response = $this->post('/subscribe/'.$topic, [
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
