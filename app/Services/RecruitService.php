<?php
namespace App\Services;
use App\Repositories\RecruitRepo;
class RecruitService
{
    use CommonService;
    //分页获取数据
    public static function getRecruitList($pager,$condition)
    {
        $info = RecruitRepo::getListBySearch($pager,$condition);
        return $info;
    }

    //新增
    public static function create($data)
    {
        return RecruitRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return RecruitRepo::modify($data['id'],$data);
    }

    //删除
    public static function delete($id)
    {
        return RecruitRepo::delete($id);
    }

    //验证唯一性
    public static function uniqueValidate($recruit_job)
    {
        $flag = RecruitRepo::getInfoByFields(['recruit_job'=>$recruit_job]);
        if(!empty($flag)){
            self::throwBizError('该职位已经存在');
        }
        return true;
    }

    //获取一条数据
    public static function getRecruitInfo($id)
    {
        return RecruitRepo::getInfo($id);
    }

}
