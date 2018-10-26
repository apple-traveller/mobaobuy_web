<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:27
 */
namespace App\Services;

use App\Repositories\ActivityPromoteRepo;

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

}
