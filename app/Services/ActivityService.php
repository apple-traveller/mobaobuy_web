<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:27
 */
namespace App\Services;

use App\Repositories\ActivityPromoteRepo;
use Carbon\Carbon;

class ActivityService
{
    use CommonService;

    /**
     * 根据条件查询列表 —— 分页
     * @param $pager
     * @param $where
     * @return mixed
     */
    public static function getListBySearch($pager,$where)
    {
        return ActivityPromoteRepo::getListBySearch($pager,$where);
    }

    /**
     * 根据id获取详情
     * @param $id
     * @return array
     */
    public static function getInfoById($id)
    {
        return ActivityPromoteRepo::getInfo($id);
    }

    /**
     * 创建
     * @param $data
     * @return mixed
     */
    public static function create($data)
    {
        $data['add_time'] = Carbon::now();
        return ActivityPromoteRepo::create($data);
    }

    /**
     * 编辑
     * @param $id
     * @param $data
     * @return bool
     */
    public static function updateById($id,$data)
    {
        return ActivityPromoteRepo::modify($id,$data);
    }

    /**
     * delete
     * @param $id
     * @return bool
     */
    public static function delete($id)
    {
        return ActivityPromoteRepo::delete($id);
    }

}
