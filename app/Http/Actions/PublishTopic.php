<?php


namespace App\Http\Actions;


use App\Http\Requests\PublishRequest;
use App\Jobs\Publish;
use App\Jobs\PublishMessageToTopic;
use App\Models\Message;
use App\Models\Topic;
use App\Notifications\PublishTopicNotification;
use App\Traits\CustomJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PublishTopic
{
    use CustomJsonResponse;

    /**
     * PublishTopicNotification a topic
     *
     * @param PublishRequest $request
     * @param $topic
     * @return JsonResponse
     */
    public function execute(PublishRequest $request, $topic): JsonResponse
    {
        try {
            $topicData = Topic::whereSlug(Str::slug($topic))->first();
            if (!$topicData) {
                return $this->failedResponse('Topic does not exist');
            }
            $message = Message::firstorCreate([
                'topic_id' => $topicData->id,
                'message_body' => json_encode($request->post())
            ]);

            //Notify Subscribers
            PublishMessageToTopic::dispatch($topic, $topicData->subscribers, json_decode($message->message_body, 0));
            return $this->successResponse('Message published to topic successfully');
        } catch (\Exception $exception) {
            return $this->serverErrorResponse('An error occurred while processing request', $exception);
        }
    }
}
