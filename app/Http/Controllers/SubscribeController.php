<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Models\Topic;
use App\Traits\CustomJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class SubscribeController extends Controller
{
    use CustomJsonResponse;

    /**
     * Subscribe to a topic
     *
     * @param SubscribeRequest $request
     * @param string $topic
     * @return JsonResponse
     */
    public function subscribe(SubscribeRequest $request, string $topic): JsonResponse
    {
        $topic = Topic::firstOrCreate([
            'slug' => Str::slug($topic),
            'topic' => $topic
        ]);

        $isSubscribed = $topic->subscribers()->whereUrl($request->get('url'))->exists();
        if ($isSubscribed) {
            return $this->failedResponse('You are already subscribed to this topic');
        }

        $topic->subscribers()->create([
            'url' => $request->get('url')
        ]);

        $response = [
            "url" => $request->get('url'),
            "topic" => $topic
        ];

        return $this->successResponse('Subscription Successful', $response);
    }
}
