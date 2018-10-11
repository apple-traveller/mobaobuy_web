<?php
namespace App\Services;
use App\Repositories\RegionRepo;
class RegionService
{
    use CommonService;

    //获取地区列表
    public static function getRegionList($parent_id)
    {
        $info = RegionRepo::getList([],['parent_id'=>$parent_id]);
        return $info;
    }

    //根据region_type获取地区
    public static function getRegionListByRegionType($region_type)
    {
        $info = RegionRepo::getList([],['region_type'=>$region_type]);
        return $info;
    }

    public static function getInfoByParentId($id)
    {
        $info = RegionRepo::getInfo($id);
        return $info;
    }

    //获取当前页面所属地区名字
    public static function getRegionNameById($id)
    {
        $info = RegionRepo::getInfo($id);
        if(empty($info)){
            return "-";
        }else{
            return $info['region_name'];
        }

    }

    //获取所有信息
    public static function getList($pager=[],$condition=[])
    {
        $regions = RegionRepo::getListBySearch($pager,$condition);
        return $regions['list'];
    }

    //获取当前页面所属地区类型
    public static function getRegionTypeById($id)
    {
        $info = RegionRepo::getInfo($id);
        if(empty($info)){
            return -1;
        }else{
            return $info['region_type'];
        }
    }

    //添加
    public static function create($data)
    {
        return RegionRepo::create($data);
    }

    //获取当前地区的所有下级id
    public static  function getids($region_id)
    {
        static $data = array();
        //获取当前地区所有下级id
        $ids = RegionRepo::getids($region_id);
        if(empty($ids)){
            return false;
        }
        foreach($ids as $val){
            $data[] = $val['region_id'];
            self::getids($val['region_id']);
        }
        return $data;
    }

    //删除
    public static function delete($region_id)
    {
        $sdata = self::getids($region_id);
        $sdata[]=$region_id;
        //return $sdata;
        return RegionRepo::delete($sdata);
    }

    //修改
    public static function modify($region_id,$region_name)
    {
        return RegionRepo::modify($region_id,['region_name'=>$region_name]);
    }

    //根据id获取地区(订单模块)
    public static function getRegion($countryid,$cityid,$provinceid,$districtid)
    {
        $country = "";
        $city = "";
        $province = "";
        $district = "";
        if($countryid!=0){
            $country = RegionRepo::getInfo($countryid)['region_name'];
        }
        if($cityid!=0){
            $city = RegionRepo::getInfo($cityid)['region_name'];
        }
        if($provinceid!=0){
            $province = RegionRepo::getInfo($provinceid)['region_name'];
        }
        if($districtid!=0){
            $district = RegionRepo::getInfo($districtid)['region_name'];
        }

        return $country." ".$city." ".$province." "."$district";
    }






}