<?php
namespace App\Services;
use App\Repositories\RegionRepo;
use Illuminate\Support\Facades\Cache;

class RegionService
{
    use CommonService;

    //获取地区列表
    public static function getRegionList($parent_id)
    {
        $info = RegionRepo::getList([],['parent_id'=>$parent_id]);
        return $info;
    }

    public static function getLevelRegion($level, $parent_id)
    {
        $cache_region = Cache::get('_region_',[]);
        if(isset($cache_region['_region_' . $level . '_' . $parent_id])){
            return $cache_region['_region_' . $level . '_' . $parent_id];
        }

        $cache_region['_region_' . $level . '_' . $parent_id] = RegionRepo::getList([], ['parent_id' => $parent_id, 'region_type' => $level]);
        Cache::forever('_region_', $cache_region);
        return $cache_region['_region_' . $level . '_' . $parent_id];
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
        Cache::forget('_region_');
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
        Cache::forget('_region_');
        $sdata = self::getids($region_id);
        $sdata[]=$region_id;
        //return $sdata;
        return RegionRepo::delete($sdata);
    }

    //修改
    public static function modify($region_id,$region_name)
    {
        Cache::forget('_region_');
        return RegionRepo::modify($region_id,['region_name'=>$region_name]);
    }

    //根据id获取地区(订单模块)
    public static function getRegion($country_id, $province_id, $city_id, $district_id, $address='')
    {
        $country = "";
        $city = "";
        $province = "";
        $district = "";
        if($country_id!=0) {
            $country = RegionRepo::getInfo($country_id)['region_name'];
        }
        if($province_id!=0){
            $province = RegionRepo::getInfo($province_id)['region_name'];
        }
        if($city_id!=0){
            $city = RegionRepo::getInfo($city_id)['region_name'];
        }
        if($district_id!=0){
            $district = RegionRepo::getInfo($district_id)['region_name'];
        }

        return $country."-".$province."-".$city."-".$district.' '.$address;
    }

    //根据id获取地区(订单模块)
    public static function getRegionApi($country_id, $province_id, $city_id, $district_id)
    {
        $country = "";
        $city = "";
        $province = "";
        $district = "";
        if($country_id!=0){
            $country = RegionRepo::getInfo($country_id)['region_name'];
        }
        if($province_id!=0){
            $province = RegionRepo::getInfo($province_id)['region_name'];
        }
        if($city_id!=0){
            $city = RegionRepo::getInfo($city_id)['region_name'];
        }
        if($district_id!=0){
            $district = RegionRepo::getInfo($district_id)['region_name'];
        }

        return $country."-".$province."-".$city."-".$district;
    }

    //商品列表
    public static function getRegionsByGoodsList($goodsList)
    {
        $region_ids = [];
        $unique_regions = [];
        foreach($goodsList as $vo)
        {
            $region_ids[] = $vo['place_id'];
        }
        $unique_region_ids = array_unique($region_ids);
        foreach ($unique_region_ids as $item) {
            $unique_regions[] = RegionRepo::getInfo($item);
        }
        return $unique_regions;
    }

    //根据地区名字返回代号
    public static function getRegionId($region_name)
    {
        $region = RegionRepo::getInfoByFields(['region_name'=>$region_name]);
        return $region['region_id'];
    }




}
