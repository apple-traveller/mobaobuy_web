<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-22
 * Time: 16:54
 */
namespace App\Services;

use App\Repositories\RecruitRepo;

class RecruitService
{
    use CommonService;

    /**
     * 招聘列表
     */
    public static function recruitList($paper,$condition){
        $recruitInfo = RecruitRepo::getListBySearch($paper,$condition);
        $recruitAllInfo = RecruitRepo::getList([],$condition);
        $place = [];
        foreach($recruitAllInfo as $v){
            if(!in_array($v['recruit_place'],$place)){
                $place[] = $v['recruit_place'];
            }
        }
        return ['recruitInfo'=>$recruitInfo,'place'=>$place];
    }

    /**
     * 招聘详情
     */
    public static function recruitDetail($condition){
        return RecruitRepo::getInfo($condition['id']);
    }
}
