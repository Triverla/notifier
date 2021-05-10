<?php


namespace App\Http\Actions;


use App\Jobs\PublishMessageToTopic;
use App\Models\Message;
use App\Models\Topic;
use App\Traits\CustomJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublishTopic
{
    use CustomJsonResponse;

    /**
     * PublishTopicNotification a topic
     *
     * @param Request $request
     * @param $topic
     * @return JsonResponse
     */
    public function execute(Request $request, $topic): JsonResponse
    {
        if (count($request->all()) === 0) {
            return $this->formValidationResponse('Request body cannot be empty and must be a Javascript object');
        }
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
