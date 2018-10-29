<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-29
 * Time: 10:44
 */
namespace App\Services;

use App\Repositories\InvoiceRepo;

class InvoiceService
{
    use CommonService;

    /**
     * 带分页的列表
     * @param $page
     * @param $condition
     * @return mixed
     */
    public static function getListBySearch($page,$condition)
    {
        return InvoiceRepo::getListBySearch($page,$condition);
    }

    /**
     * 根据id查info
     * @param $id
     * @return array
     */
    public static function getInfoById($id)
    {
        $info =  InvoiceRepo::getInfo($id);
        $info['address_str'] = RegionService::getRegion($info['country'],$info['province'],$info['city'],$info['district']);
        return $info;
    }

    /**
     * 审核开票
     * @param $id
     * @param $data
     * @return bool
     */
    public static function verifyInvoice($id,$data)
    {
        return InvoiceRepo::modify($id,$data);
    }
}
