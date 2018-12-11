<?php

namespace App\Console\Commands;

use App\Services\OrderInfoService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

class AutoCancelOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AutoCancelOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //自动取消【未付款】超过三十分钟的【限时抢购】或【清仓特卖】订单和 未付订金的集采火拼
        $c['opt'] = 'OR';
        $c['extension_code'] = 'promote|consign';
        $c['pay_status'] = 0;
        $where[] = $c;

        $c_wholesale['opt'] = 'OR';
        $c_wholesale['extension_code'] = 'wholesale';
        $c_wholesale['deposit_status'] = 0;
        $where[] = $c_wholesale;

        $where['add_time|<'] = date('Y-m-d H:i:s',strtotime("-30 minute"));
        $pager = [
            'page'=>1,
            'pageSize'=>5,
        ];
        $info = OrderInfoService::getOrderInfoList($pager,$where);
//        if(!empty($info)){
            Log::info('测试自动取消');
//        }
        try{
            foreach ($info['list'] as $k=>$v){
                //执行取消操作
                OrderInfoService::orderCancel($v['id']);
            }
        }catch (Exception $e){
            Log::info($e->getMessage());
        }
    }
}
