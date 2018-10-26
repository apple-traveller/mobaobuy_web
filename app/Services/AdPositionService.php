<?php
namespace App\Services;
use App\Repositories\AdPositionRepo;
use App\Repositories\AdRepo;
class AdPositionService
{
    use CommonService;

    //列表
    public static function getAdPositionList($pager,$condition)
    {
        return AdPositionRepo::getListBySearch($pager,$condition);
    }

    //无列表
    public static function getAdPositionLists()
    {
        return AdPositionRepo::getList();
    }

    //添加
    public static function create($data)
    {
        return AdPositionRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return AdPositionRepo::modify($data['id'],$data);
    }

    //删除
    public static function delete($id)
    {
        try{
            self::beginTransaction();
            $flag = AdPositionRepo::delete($id);
            if($flag){
                $ad = AdRepo::getList([],['position_id'=>$id]);
                foreach ($ad as $v){
                    AdRepo::delete($v['id']);
                }
                self::commit();
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    //获取一条数据
    public static function getAdPositionById($id)
    {
        return AdPositionRepo::getInfo($id);
    }

}