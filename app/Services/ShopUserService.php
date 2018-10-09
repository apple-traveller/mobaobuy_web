<?php
namespace App\Services;
use App\Repositories\ShopUserRepo;
use function Psy\sh;

class ShopUserService
{
    use CommonService;

    //分页
    public static function getShopUserList($pager,$condition)
    {
        return ShopUserRepo::getListBySearch($pager,$condition);
    }

    //删除
    public static function delete($id)
    {
        return ShopUserRepo::delete($id);
    }

    //查找一条数据
    public static function getShopUserById($id)
    {
        return ShopUserRepo::getInfo($id);
    }

    //验证唯一性
    public static function uniqueValidate($condition)
    {
        $info = ShopUserRepo::getInfoByFields(['shop_id'=>$condition['shop_id'],'user_name'=>$condition['user_name']]);
        if(!empty($info)){
            self::throwBizError('该用户名已经存在！');
        }
        return $info;
    }

    //添加
    public static function create($data)
    {
        return ShopUserRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return ShopUserRepo::modify($data['id'],$data);
    }

    /**
     * 获取非店铺负责人的职员
     * @param $shop_id
     * @param $user_id
     * @return array
     */
    public static function getNotSuper($pager,$shop_id,$user_id)
    {
        $condition = [];
        $condition['shop_id'] = $shop_id;
        $shopInfo = ShopService::getShopById($shop_id);
        $user_info = ShopUserRepo::getInfo($user_id);
        if (!empty($shopInfo)){
            $condition['user_name'] = "!".$shopInfo['contactName'];
        }
        if (!empty($user_info) || $user_info['user_name'] != $shopInfo['contactName']){
            $condition['is_super'] = 0;
        }
        $list = ShopUserRepo::getListBySearch($pager,$condition);
        if (!empty($list['list'])){
            foreach ($list['list'] as $k=>$v){
                $list['list'][$k]['shop_name'] = $shopInfo['shop_name'];
                unset($list['list'][$k]['password']);
            }
        }
        return $list;
    }

}
