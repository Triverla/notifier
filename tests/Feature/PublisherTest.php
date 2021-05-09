<?php

namespace Tests\Feature;

use App\Http\Requests\PublishRequest;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublisherTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Can Publish to Topic.
     *
     * @return void
     */
    public function test_can_publish_message_to_topic_without_subscribers()
    {
        $this->withExceptionHandling();
        $topic = Topic::factory()->create([
            'topic' => 'topic1',
            'slug' => Str::slug('topic1')
        ]);
        $request = new PublishRequest([
            'body' => 'hello'
        ]);

        $response = $this->post('/publish/' . $topic->slug, $request->query());
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }

    /**
     * Test Can Publish to Topic.
     *
     * @return void
     */
    public function test_can_publish_message_to_topic_with_multiple_subscribers()
    {
        $this->withExceptionHandling();
        $topic = Topic::factory()->create([
            'topic' => 'topic1',
            'slug' => Str::slug('topic1')
        ]);
        $this->post('/subscribe/' . $topic->slug, [
            'url' => 'https://webhook.site/c3b5acb1-c06b-49ed-b5e1-4cb94543f3cd'
        ]);

        $response = $this->post('/publish/' . $topic->slug, [
            'body' => 'hello'
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }
}
