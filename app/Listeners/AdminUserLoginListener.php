<?php

namespace App\Listeners;

use App\Events\AdminUserLogin;
use App\Services\AdminLogService;
use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminUserLoginListener
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
     * @param  AdminUserLogin  $event
     * @return void
     */
    public function handle(AdminUserLogin $event)
    {
        $data = $event->data;

        $info = AdminService::getInfo($data['user_id']);

        //写入日志
        $adminLog=[
            'admin_id' => $data['user_id'],
            'real_name'=>$info['real_name'],
            'log_time'=>Carbon::now(),
            'ip_address'=>$data['client_ip'],
            'log_info'=>"后台登录"
        ];
        AdminLogService::create($adminLog);

        //修改用户登录次数
        AdminService::updateLoginField($info['id'], ['client_ip' => $data['client_ip'] ]);
    }
}
