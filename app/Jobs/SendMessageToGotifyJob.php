<?php

namespace App\Jobs;

use App\Notifications\Dto\GotifyMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendMessageToGotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private GotifyMessage $message,
        private string $gotifyUrl,
        private string $gotifyToken
    ) {
        $this->onQueue('high');
    }

    public function handle(): void
    {
        $url = rtrim($this->gotifyUrl, '/') . '/message';

        $response = Http::withHeaders([
            'X-Gotify-Key' => $this->gotifyToken,
            'Content-Type' => 'application/json',
        ])->post($url, [
            'title' => $this->message->title,
            'message' => $this->message->message,
            'priority' => $this->message->priority,
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('Gotify notification failed with '.$response->status().' status code.'.$response->body());
        }
    }
}