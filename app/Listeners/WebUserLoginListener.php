<?php

namespace App\Listeners;

use App\Events\WebUserLogin;
use App\Repositories\UserRepo;
use App\Services\UserLogService;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WebUserLoginListener
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
    public function handle(WebUserLogin $event)
    {
        $data = $event->data;

        //写入日志
        $userLog = array(
            'user_id' => $data['user_id'],
            'ip_address' => $data['client_ip'],
            'log_time' => Carbon::now(),
            'log_info' => '会员登陆'
        );
        UserLogService::create($userLog);

        //修改用户登录次数
        $user_info = UserRepo::getInfo($data['user_id']);
        $lastInfo = [
            'last_ip' => $data['client_ip'],
            'last_time' => Carbon::now(),
            'visit_count' => $user_info['visit_count'] + 1
        ];
        UserRepo::modify($data['user_id'], $lastInfo);
    }
}
