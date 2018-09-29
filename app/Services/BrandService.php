<?php
namespace App\Services;
use App\Repositories\BrandRepo;
class BrandService
{
    use CommonService;

    //分页
    public static function getBrandList($pager,$condition)
    {
        return BrandRepo::getListBySearch($pager,$condition);
    }

    //修改
    public static function modify($data)
    {
        return BrandRepo::modify($data['id'],$data);
    }

    //获取一条数据
    public static function getBrandInfo($id)
    {
        return BrandRepo::getInfo($id);
    }

    //唯一性验证
    public static function uniqueValidate($brand_name)
    {
        $flag = BrandRepo::getInfoByFields(['brand_name'=>$brand_name]);
        if($flag){
            self::throwBizError('该品牌名称已经存在');
        }
    }

    //保存
    public static function create($data)
    {
        return BrandRepo::create($data);
    }

    //删除
    public static function delete($id)
    {
        return BrandRepo::delete($id);
    }
}