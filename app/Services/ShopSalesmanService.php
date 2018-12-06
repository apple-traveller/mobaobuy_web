<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-12-06
 * Time: 16:31
 */
namespace App\Services;

use App\Repositories\ShopSalesmanRepo;

class ShopSalesmanService
{
    use CommonService;

    /**
     * 列表
     * @param $order
     * @param $condition
     * @param $columns
     * @return mixed
     */
    public static function getList($order,$condition,$columns)
    {
        return ShopSalesmanRepo::getList($order,$condition,$columns);
    }

    /**
     * 分页列表
     * @param $pager
     * @param $condition
     * @return mixed
     */
    public static function getListWithPage($pager,$condition)
    {
        return ShopSalesmanRepo::getListBySearch($pager,$condition);
    }

    /**
     * 多条件获取详情
     * @param $condition
     * @return array
     */
    public static function getInfoByFields($condition)
    {
        return ShopSalesmanRepo::getInfoByFields($condition);
    }

    /**
     * 添加
     * @param $data
     * @return mixed
     */
    public static function create($data)
    {
        return ShopSalesmanRepo::create($data);
    }

    /**
     * 修改
     * @param $id
     * @param $data
     * @return bool
     */
    public static function updateById($id,$data)
    {
        return ShopSalesmanRepo::modify($id,$data);
    }
}
