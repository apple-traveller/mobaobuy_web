<?php
namespace App\Services;
use App\Repositories\SysConfigRepo;
class SysConfigService
{
    use CommonService;
    public static function sysCacheSet($where=[]){
//         $where['code'] = 'individual_reg_closed';
//         if(empty($where)){}
         $sysCache = SysConfigRepo::search([],$where);
         $arr = [];
         foreach ($sysCache['list'] as $key=>$value){
            if($value['parent_id'] != 0){
                if($value['parent_id'] == 1){
                    $arr['shop_info'][] = $value;
                }else if($value['parent_id'] == 2){
                    $arr['basic'][] = $value;
                }else if($value['parent_id'] == 3){
                    $arr['display'][] = $value;
                }else if($value['parent_id'] == 4){
                    $arr['path'][] = $value;
                }
            }
         }
         return $arr;
    }




    //根据parent_id获取配置信息
    public static function getInfo($parent_id)
    {
        $configs = SysConfigRepo::getList([],['parent_id'=>$parent_id]);
        return $configs;
    }

    public static function modify($data)
    {
        try{
            self::beginTransaction();
            foreach($data as $k=>$v){
                $flag = SysConfigRepo::modify($k,['value'=>$v]);
            }
            self::commit();
            return true;
        }catch(\Exception $e){
            self::rollBack();
            Self::throwBizError('修改失败');
        }

    }


}