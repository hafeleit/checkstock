<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SlackService
{
    public function slackApi($message)
    {
      $response = Http::withToken(config('services.slack.api_token'))
          ->post('https://slack.com/api/chat.postMessage', [
              'channel' => 'C088H8QFRHC',
              'text' => $message,
          ]);

      if ($response->failed()) {
          throw new \Exception('Slack API request failed');
      }

      // Log การส่งข้อความ
      Log::channel('slack_api')->info('Slack API Response', [
          'timestamp' => now(),
          'responseCode' => $response->status(),
          'responseData' => $response->json(),
      ]);

      return $response->json();
    }
}
