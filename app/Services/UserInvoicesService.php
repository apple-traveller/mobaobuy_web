<?php
namespace App\Services;
use App\Repositories\RegionRepo;
use App\Repositories\UserInvoicesRepo;
use Carbon\Carbon;

class UserInvoicesService
{
    use CommonService;
    public static function create($data){
        $data['add_time'] = Carbon::now();
        return UserInvoicesRepo::create($data);
    }

    public static function editInvoices($id,$data){
        return UserInvoicesRepo::modify($id,$data);
    }

    public static function invoicesById($condition)
    {
        return UserInvoicesRepo::getList($order = [], $condition);
    }

    //根据user_id获取发票信息
    public static function getInfoByUserId($user_id)
    {
        return UserInvoicesRepo::getInfoByFields(['user_id'=>$user_id]);
    }

    //根据id获取信息
    public static function getInvoice($id)
    {
        $invoiceInfo =  UserInvoicesRepo::getInfo($id);

        // 收票地址
        $invoiceInfo['address_ids'] =  $invoiceInfo['country'] ."|". $invoiceInfo['province'] ."|".$invoiceInfo['city'] ."|".$invoiceInfo['district'];
        $invoiceInfo['address_str'] = RegionService::getRegion($invoiceInfo['country'], $invoiceInfo['province'], $invoiceInfo['city'], $invoiceInfo['district'] );
        return $invoiceInfo;
    }


}
