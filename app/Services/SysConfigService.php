<?php

<<<<<<< HEAD
namespace App\Services\Web;
use App\Repositories\SysConfigRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SysConfigService
{
    use BaseService;
    public static function sysCacheSet($where=[]){
//         $where['code'] = 'individual_reg_closed';
//         if(empty($where)){}
         $sysCache = SysConfigRepository::search([],$where);
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



=======
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
>>>>>>> 039764dbb692d11bb288c6921e8081269efa3aaf

}