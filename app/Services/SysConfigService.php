<?php
namespace App\Services;
use App\Repositories\SysConfigRepo;
use Illuminate\Support\Facades\Cache;

class SysConfigService
{
    use CommonService;

    public static function getConfig($code = ''){
        $value = Cache::rememberForever('_sys_config', function() {
            $list = SysConfigRepo::getList([], [], ['code', 'value']);
            return array_column($list, 'value', 'code');
        });

        if(empty($code)){
            return $value;
        }
        return $value[$code] ?? '';
    }

    public static function getTopList(){
        return SysConfigRepo::getList(['sort_order'=>'asc'],['parent_id'=> 0 ], ['id', 'code', 'name']);
    }

    public static function getListByParentID($parent_id){
        return SysConfigRepo::getList(['sort_order'=>'asc'],['parent_id'=>$parent_id]);
    }

    public static function modify($data)
    {
        try{
            self::beginTransaction();
            foreach($data as $k=>$v){
                SysConfigRepo::modifyByCode($k, ['value'=>$v]);
            }
            Cache::forget('_sys_config');
            self::commit();
            return true;
        }catch(\Exception $e){
            self::rollBack();
            Self::throwBizError('修改失败');
        }

    }


}