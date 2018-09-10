<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\SysConfigRepo;
class SysConfigService extends BaseService
{
    //根据parent_id获取配置信息
    public static function getInfo($parent_id)
    {
        $configs = SysConfigRepo::getInfo($parent_id);
        return $configs;
    }

    public static function modify($data)
    {
        self::beginTransaction();
        foreach($data as $k=>$v){
            $flag = SysConfigRepo::modify($k,['value'=>$v]);
            if(!$flag){
                self::rollBack();
                return false;
            }
        }
        self::commit();
        return true;
    }

}