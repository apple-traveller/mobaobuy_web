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
    public static function getList($order,$condition,$columns=['*'])
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
        $salesman_list = ShopSalesmanRepo::getListBySearch($pager,$condition);
        if($salesman_list['total'] > 0){
            foreach ($salesman_list['list'] as $k=>$v){
                $shop_info = ShopService::getShopById($v['shop_id']);
                $salesman_list['list'][$k]['company_name'] = $shop_info['company_name'];
            }
        }

        return $salesman_list;
    }

    /**
     * 多条件获取详情
     * @param $condition
     * @return array
     */
    public static function getInfoByFields($condition)
    {
        $info = ShopSalesmanRepo::getInfoByFields($condition);
        if($info){
            $shop_info = ShopService::getShopById($info['shop_id']);
            if(!empty($shop_info)){
                $info['company_name'] = $shop_info['company_name'];
            }else{
                $info['company_name'] = '';
            }
        }else{
            $info = [];
        }
        return $info;
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
