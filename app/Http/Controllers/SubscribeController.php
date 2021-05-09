<?php

namespace App\Http\Controllers;

use App\Http\Actions\CreateSubscription;
use App\Http\Requests\SubscribeRequest;
use App\Models\Topic;
use App\Traits\CustomJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class SubscribeController extends Controller
{
    use CustomJsonResponse;

    /**
     * CreateSubscription to a topic
     *
     * @param SubscribeRequest $request
     * @param string $topic
     * @return JsonResponse
     */
    public function index(SubscribeRequest $request, string $topic): JsonResponse
    {
        return app(CreateSubscription::class)->execute($request, $topic);
    }
}
