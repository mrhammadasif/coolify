<?php

namespace App\Notifications\Channels;

interface SendsGotify
{
    public function gotifyNotificationSettings();
}