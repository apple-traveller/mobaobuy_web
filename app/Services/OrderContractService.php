<?php
namespace App\Services;
use App\Repositories\OrderContractRepo;
use Carbon\Carbon;

class OrderContractService
{
    use CommonService;

    public static function checkOrderContract($data){
        if($data['order_id'] == '' || $data['from_id'] == ''){
            self::throwBizError('上传出错，请重试');
        }
        $data['add_time'] = Carbon::now();
        $data['from'] = 1;
        $data['is_delete'] = 0;
        return OrderContractRepo::create($data);
    }
}