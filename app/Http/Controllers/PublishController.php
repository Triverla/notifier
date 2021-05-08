<?php

namespace App\Http\Controllers;

use App\Http\Actions\PublishTopic;
use App\Http\Requests\PublishRequest;
use App\Traits\CustomJsonResponse;
use Illuminate\Http\JsonResponse;

class PublishController extends Controller
{
    use CustomJsonResponse;

    /**
     * PublishTopicNotification a topic
     *
     * @param PublishRequest $request
     * @param string $topic
     * @return JsonResponse
     */
    public function index(PublishRequest $request, string $topic): JsonResponse
    {
        return app(PublishTopic::class)->execute($request, $topic);
    }
}
