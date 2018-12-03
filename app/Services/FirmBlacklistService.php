<?php
namespace App\Services;
use App\Repositories\FirmBlacklistRepo;
use App\Repositories\UserRepo;
use App\Repositories\ShopRepo;
class FirmBlacklistService
{
    use CommonService;

    //获取黑名单列表(导出excel表)
    public static function getBlacklists($fields)
    {
        $info = FirmBlacklistRepo::getList(['id'=>'asc'],[],$fields);
        return $info;
    }

    //获取黑名单列表（分页）
    public static function getBlackList($pager,$condition)
    {
        $info = FirmBlacklistRepo::getListBySearch($pager,$condition);
        return $info;
    }

    //添加
    public static function create($data)
    {
        try{
            self::beginTransaction();
            //查询用户
            $user = UserRepo::getList([],['nick_name'=>$data['firm_name'],'is_firm'=>1]);
            if(!empty($user)){
                UserRepo::modify($user[0]['id'],['is_freeze'=>1]);
            }
            //查询店铺
            $shop = ShopRepo::getList([],['company_name'=>$data['firm_name'],'is_validated'=>1]);
            if(!empty($shop)){
                UserRepo::modify($shop[0]['id'],['is_freeze'=>1]);
            }
            $flag = FirmBlacklistRepo::create($data);
            self::commit();
            return $flag;
        }catch(\Exception $e){
            self::throwBizError($e->getMessage());
        }
    }



    //检测企业名称是否已经存在
    public static function validateUnique($firm_name)
    {
        return FirmBlacklistRepo::getInfoByFields(['firm_name'=>$firm_name]);
    }

    //删除
    public static function delete($id)
    {
        try{
            if(is_array($id)){
                foreach($id as $k=>$v){
                    $info = FirmBlacklistRepo::delete($v);
                    if(!$info){
                        return false;
                    }
                }
            }else{
                $info = FirmBlacklistRepo::delete($id);
            }

        }catch(\Exception $e){
            self::throwBizError($e->getMessage());
        }

        return true;
    }



}