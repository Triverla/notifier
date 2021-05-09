<?php


namespace App\Http\Actions;


use App\Http\Requests\SubscribeRequest;
use App\Models\Topic;
use App\Traits\CustomJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CreateSubscription
{
    use CustomJsonResponse;
    /**
     * CreateSubscription to a topic
     *
     * @param SubscribeRequest $request
     * @param string $topic
     * @return JsonResponse
     */
    public function execute(SubscribeRequest $request, string $topic): JsonResponse
    {
        try {
            $data = Topic::firstOrCreate([
                'slug' => Str::slug($topic),
                'topic' => $topic
            ]);

            $isSubscribed = $data->subscribers()->whereUrl($request->url)->exists();
            if ($isSubscribed) {
                return $this->failedResponse('You are already subscribed to this topic');
            }

            $data->subscribers()->create([
                'url' => $request->url
            ]);

            $response = [
                'url' => $request->url,
                'topic' => $topic
            ];

            return $this->successResponse('Subscription Successful', $response);
        }catch (\Exception $exception){
            return $this->serverErrorResponse('An error occurred while processing request', $exception);
        }
    }
}
