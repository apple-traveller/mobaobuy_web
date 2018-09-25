<?php

namespace App\Listeners;

use App\Events\SendSms;
use App\Events\WebUserLogin;
use App\Services\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSmsListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WebUserLogin  $event
     * @return void
     */
    public function handle(SendSms $event)
    {
        $data = $event->data;

        SmsService::sendSms($data['phoneNumbers'], $data['type'], $data['tempParams']);
    }
}
