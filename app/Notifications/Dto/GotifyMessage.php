<?php

namespace App\Notifications\Dto;

class GotifyMessage
{
    public function __construct(
        public string $title,
        public string $message,
        public int $priority = 5
    ) {}

    public static function lowPriority(): int
    {
        return 2;
    }

    public static function normalPriority(): int
    {
        return 5;
    }

    public static function highPriority(): int
    {
        return 8;
    }
}