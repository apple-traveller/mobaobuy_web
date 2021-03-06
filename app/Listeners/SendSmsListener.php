<?php

namespace App\Listeners;

use App\Events\SendSms;
use App\Events\WebUserLogin;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSmsListener //implements ShouldQueue
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
        if(Carbon::parse($data['_event_data'])->addMinute(1) > Carbon::now()){
            SmsService::sendSms($data['phoneNumbers'], $data['type'], $data['tempParams']);
        }
    }
}
