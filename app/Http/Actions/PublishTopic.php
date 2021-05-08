<?php


namespace App\Http\Actions;


use App\Http\Requests\PublishRequest;
use App\Models\Message;
use App\Models\Topic;
use App\Traits\CustomJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PublishTopic
{
    use CustomJsonResponse;

    /**
     * PublishTopic a topic
     *
     * @param PublishRequest $request
     * @param $topic
     * @return JsonResponse
     */
    public function execute(PublishRequest $request, $topic): JsonResponse
    {
        try {
            $topic = Topic::whereSlug(Str::slug($topic))->first();
            if (!$topic) {
                return $this->failedResponse('Topic does not exist');
            }
            Message::create([
                'topic_id' => $topic->id,
                'message_body' => $request->body
            ]);

            return $this->successResponse('Message published to topic successfully');
        } catch (\Exception $exception) {
            return $this->serverErrorResponse('An error occurred while processing request', $exception);
        }
    }
}