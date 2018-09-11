<?php
namespace App\Services;
use App\Repositories\GoodsCategoryRepo;
class GoodsCategoryService
{
    use CommonService;
    public static function GoodsCategoryInfo($where=[]){
        return GoodsCategoryRepo::search([],$where);
    }

    //分类添加
    public static function categoryCreate($data){
        return GoodsCategoryRepo::create($data);
    }

    //分类编辑
    public static function categoryUpdate($id,$data){
        return GoodsCategoryRepo::modify($id,$data);
    }



    //根据id获取一条数据
    public static function getInfo($id)
    {
        $res = GoodsCategoryRepo::getInfo($id);
        return $res;
    }
    //获取列表
    public static function getList($parent_id)
    {
        $res = GoodsCategoryRepo::search([],['parent_id'=>$parent_id,'order'=>'asc']);
        return $res['list'];
    }

    //获取图标库文件所有文件
    public static function getIcons()
    {
        $path = $_SERVER['DOCUMENT_ROOT'].'/default/icon';//G:/phpStudy/PHPTutorial/WWW/mbb_web/public/default/icon
        $filedata = array();
        if(!is_dir($path)) return false;
        $handle = opendir($path);
        if($handle){
            while(($fl = readdir($handle)) !== false){
                if($fl!="."&&$fl!=".."){
                    $filedata[]=$fl;
                }

            }
        }
        return $filedata;
    }

    //验证唯一性
    public static function uniqueValidate($cat_name)
    {
        $info = GoodsCategoryRepo::exist($cat_name);
        if(!empty($info)){
            self::throwError('分类名称已经存在！');
        }
        return $info;
    }

    //添加
    public static function create($data)
    {
        return GoodsCategoryRepo::create($data);
    }

    //修改
    public static function modify($id,$data)
    {
        return GoodsCategoryRepo::modify($id,$data);
    }

    //获取所有分类
    public static function getCates()
    {
        $res = GoodsCategoryRepo::search([],[]);
        return $res['list'];
    }

    //分类树,获取所有分类
    public static function getCatesTree($cates,$id=0,$level=1)
    {
        static $data;
        foreach($cates as $k=>$v){
            if($v['parent_id']==$id){
                $data[$k]=$v;
                $data[$k]['level']=$level;
                self::getCatesTree($cates,$v['id'],$level+1);
            }
        }
        return $data;
    }

    //判断当前分类是第几级
    public static function getLevel($parent_id){
        $data = self::getCates();
        $cates = self::getCatesTree($data);
        $level = "";
        foreach($cates as $k=>$v){
            if($v['parent_id']==$parent_id){
                $level = $v['level'];
                break;
            }
        }
        return $level;
    }

    //获取下级ld
    public static function getChilds($cates,$id)
    {
        static $ids;
        foreach($cates as $k=>$v){
            if($v['parent_id']==$id){
                $ids[] = $v['id'];
                self::getChilds($cates,$v['id']);
            }
        }

        return $ids;
    }

    //删除
    public static function delete($ids)
    {
        return GoodsCategoryRepo::delete($ids);
    }


}