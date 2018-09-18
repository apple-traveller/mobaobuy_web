<?php
namespace App\Services;
use App\Repositories\FirmBlacklistRepo;
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
        $flag = FirmBlacklistRepo::create($data);
        return $flag;
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