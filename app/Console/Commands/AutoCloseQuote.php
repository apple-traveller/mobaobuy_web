<?php

namespace App\Console\Commands;

use App\Services\ShopGoodsQuoteService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoCloseQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AutoCloseQuote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * handle
     */
    public function handle()
    {
        //自动闭市 报价截止时间变成当天下午5:00 同时检查闭市的报价对应的购物车信息页清除
        $day = date('Y-m-d');
        $set_time = $day . ' ' .getConfig('close_quote');
        $start_time = $day . ' 00:00:00';
        $end_time = $day . ' 23:59:59';

        $res = ShopGoodsQuoteService::closeQuote(
            [
                'add_time|>=' => $start_time,
                'add_time|<=' => $end_time,
                'is_delete' => 0,
                'type' => '1|2',
                'is_self_run' => 1

            ],
            [
                'expiry_time' => $set_time
            ]
        );

//        Log::info($res);

    }
}
