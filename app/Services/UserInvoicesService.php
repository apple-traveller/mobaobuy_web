<?php
namespace App\Services;
use App\Repositories\RegionRepo;
use App\Repositories\UserInvoicesRepo;

class UserInvoicesService
{
    use CommonService;
    public static function create($data){
        return UserInvoicesRepo::create($data);
    }

    public static function editInvoices($id,$data){
        return UserInvoicesRepo::modify($id,$data);
    }

    public static function invoicesById($condition){
        return UserInvoicesRepo::getList($order=[],$condition);
    }


}