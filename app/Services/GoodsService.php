<?php
namespace App\Services;
use App\Repositories\GoodsRepo;
use App\Repositories\UnitRepo;
use App\Repositories\AttributeRepo;
use App\Repositories\AttributeValueRepo;
class GoodsService
{
    use CommonService;
    //产品列表（分页）
    public static function getGoodsList($pager,$condition)
    {
        return GoodsRepo::getListBySearch($pager,$condition);
    }

    //无分页
    public static function getGoods($condition,$columns)
    {
        return GoodsRepo::getList([],$condition,$columns);
    }

    //验证唯一性
    public static function uniqueValidate($goods_name)
    {
        $info = GoodsRepo::getInfoByFields(['goods_name'=>$goods_name]);
        //dd($info);
        if(!empty($info)){
            self::throwBizError('该产品已经存在！');
        }
        return $info;
    }

    //添加
    public static function create($data)
    {
        return GoodsRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return GoodsRepo::modify($data['id'],$data);
    }

    //获取一条产品
    public static function getGoodInfo($id)
    {
        return GoodsRepo::getInfo($id);
    }

    //获取所有的单位列表
    public  static function getUnitList($pager,$condition)
    {
        return UnitRepo::getListBySearch($pager,$condition);
    }

    //判断属性名是否存在并返回一条
    public static  function getAttr($condition)
    {
        return AttributeRepo::getInfoByFields($condition);
    }

    //查询所有属性名
    public static  function getAttrs($condition)
    {
        return AttributeRepo::getList([],$condition);
    }

    //保存属性名
    public static function saveAttrName($data)
    {
        return AttributeRepo::create($data);
    }

    //判断属性值是否存在并返回一条
    public  static function getAttrValue($condition)
    {
        return AttributeValueRepo::getInfoByFields($condition);
    }

    //查询所有属性值
    public static  function getAttrValues($condition)
    {
        return AttributeValueRepo::getList([],$condition);
    }

    //保存属性值
    public static function saveAttrValue($data)
    {
        return AttributeValueRepo::create($data);
    }



}