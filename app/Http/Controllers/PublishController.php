<?php

namespace App\Http\Controllers;

use App\Http\Actions\PublishTopic;
use App\Traits\CustomJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublishController extends Controller
{
    use CustomJsonResponse;

    /**
     * PublishTopicNotification a topic
     *
     * @param Request $request
     * @param string $topic
     * @return JsonResponse
     */
    public function index(Request $request, string $topic): JsonResponse
    {
        return app(PublishTopic::class)->execute($request, $topic);
    }
}
