<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:27
 */
namespace App\Services;

use App\Repositories\InquireRepo;
use Carbon\Carbon;

class InquireService
{
    use CommonService;


    /**
     * 求购列表
     */
    public static function inquireList($pager,$condition){
        return InquireRepo::getListBySearch($pager,$condition);
    }


    //获取列表数据
    public static function getInquireList($pager,$condition)
    {
        return InquireRepo::getListBySearch($pager,$condition);
    }


}
