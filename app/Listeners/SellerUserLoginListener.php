<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-27
 * Time: 9:55
 */
namespace App\Listeners;
use App\Events\SellerUserLogin;
use App\Repositories\ShopRepo;
use App\Repositories\ShopUserRepo;
use App\Services\ShopLogService;
use Carbon\Carbon;

class SellerUserLoginListener
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
     * @param SellerUserLogin $event
     */
    public function handle(SellerUserLogin $event)
    {
        $data = $event->data;
        //插入日志
        $log_data = [
            'shop_id' =>$data['shop_id'],
            'shop_user_id' => $data['user_id'],
            'log_time' => Carbon::now(),
            'ip_address' => $data['ip'],
            'log_info' => '商户登录'
        ];
        ShopLogService::create($log_data);
        // 修改职员登录次数
        $visit_count = ShopUserRepo::getMax('visit_count',['id'=>$data['user_id']]);
        $user_data = [
            'last_time' =>Carbon::now(),
            'last_ip' => $data['ip'],
            'visit_count' => $visit_count+1
        ];
        ShopUserRepo::modify($data['user_id'],$user_data);
        // 修改店铺登录次数
        $shop_visit = ShopRepo::getMax('visit_count',['id'=>$data['shop_id']]);
        $shop_data = [
            'last_time' =>Carbon::now(),
            'last_ip' => $data['ip'],
            'visit_count' => $shop_visit+1
        ];
        ShopRepo::modify($data['shop_id'],$shop_data);
    }
}
