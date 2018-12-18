<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\GoodsCategoryRepo;
use Illuminate\Http\Request;
use App\Services\GoodsCategoryService;
class GoodsCategoryController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $parent_id = $request->input('parent_id',0);
        $goodsCategory = GoodsCategoryService::getInfo($parent_id);//根据id获取信息
        //判断当前分类是几级
        $level = GoodsCategoryService::getLevel($parent_id);
        $last_parent_id=0;
        if(!empty($goodsCategory)){
            $last_parent_id = $goodsCategory['parent_id'];
        }
        $goodsCategorys = GoodsCategoryService::getList($parent_id);
        return $this->display('admin.goodscategory.list',
            ['goodsCategorys'=>$goodsCategorys,
              'last_parent_id'=>$last_parent_id,
                'level'=>$level
            ]);
    }

    //排序
    public function sort(Request $request)
    {
        $data = $request->all();
        try{
            $info = GoodsCategoryService::modify($data);
            if(!$info){
                return $this->result('',400,'更新失败');
            }
            return $this->result("/admin/goodscategory/list?parent_id=".$info['parent_id'],200,'更新成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }


    }

    //添加
    public function addForm(Request $request)
    {
        $parent_id = $request->input('parent_id',0);
        $goodsCategory = GoodsCategoryService::getInfo($parent_id);//根据id获取信息
        //获取图标库文件
        $icons = GoodsCategoryService::getIcons();

        //获取所有的栏目
        $cates = GoodsCategoryService::getCates();
        //获取所有的栏目(无限极分类)
        $catesTree = GoodsCategoryService::getCatesTree($cates,0,1);
        //dd($catesTree);
        return $this->display('admin.goodscategory.add',
            ['icons'=>$icons,
              'catesTree'=>$catesTree,
                'parent_id'=>empty($goodsCategory['id'])?0:$goodsCategory['id']
            ]);
    }

    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $cate= GoodsCategoryService::getInfo($id);//根据id获取信息
        //获取图标库文件
        $icons = GoodsCategoryService::getIcons();
        //获取所有的栏目
        $cates = GoodsCategoryService::getCates();
        //获取所有的栏目(无限极分类)
        $catesTree = GoodsCategoryService::getCatesTree($cates,0,1);
        foreach($catesTree as $k=>$v){
            if($v['id']==$id){
                unset($catesTree[$k]);//选着parent_id的时候不能存在自己的数据
            }
        }
        return $this->display('admin.goodscategory.edit',['icons'=>$icons,'catesTree'=>$catesTree,'cate'=>$cate]);
    }

    public  function save(Request $request)
    {

        $data = array();
        $errorMsg = array();
        $id = $request->input('id',0);
        $data = [
            'cat_name'=>$request->input('cat_name'),
            'cat_alias_name'=>$request->input('cat_alias_name'),
            'parent_id'=>$request->input('parent_id'),
            'sort_order'=>$request->input('sort_order'),
            'is_show'=>$request->input('is_show'),
            'is_nav_show'=>$request->input('is_nav_show'),
            'is_top_show'=>$request->input('is_top_show'),
            'cat_icon'=>$this->requestGetNotNull('cat_icon')
        ];
        //dd($data);

        if(empty($data['cat_name'])){
            $errorMsg[] = '分类名称不能为空';
        }
        if(empty($data['cat_alias_name'])){
            $errorMsg[] = '分类别名不能为空';
        }
        if($data['parent_id']==""){
            $errorMsg[] = '上级分类不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        try{
            if(empty($id)){
                GoodsCategoryService::uniqueValidate($data['cat_name']);//唯一性验证
                $info = GoodsCategoryService::create($data);
            }else{
                $data['id'] = $id;
                $info = GoodsCategoryService::modify($data);
            }
            if(!$info){
                return $this->error('保存失败');
            }
            return $this->success('保存成功！',url("/admin/goodscategory/list")."?parent_id=".$data['parent_id']);
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //上传自定义图标
    public function upload(Request $request)
    {
        $file = $_FILES['file'];
        if(!empty($file)){
            if($file['size']>config('website.icon_size'))
            {
                return $this->result( '',400,  '图片超过' . config('website.common_size')/(1024*1024) . 'M' );
            }
        }
        //检测图片格式
        $ext = explode('.', $file['name']);
        $ext = array_pop($ext);
        $allowImgs = config('website.icon_img'); //读取系统配置的上传图片配置
        if(!in_array($ext, $allowImgs)){
            return $this->result('',400, '只能上传' . join(',',$allowImgs) . '的图片');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $date = date('Ymd');
        $new_file_name = date('YmdHis') . '.' . $ext;
        $path = "uploads/".$date."/";
        $file_path = $path . $new_file_name;

        //判断当前的目录是否存在，若不存在就新建一个!
        if (!is_dir($path)){mkdir($path, 0777, true);}
        //print_r($file['tmp_name']);die;
        $upload_result = move_uploaded_file($file['tmp_name'], $file_path);

        //此函数只支持 HTTP POST 上传的文件
        if ($upload_result) {
            return $this->result( "/".$file_path ,200,  '上传成功');
        } else {
            return $this->result('',400,   '上传失败');
        }

    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        //获取所有的栏目
        $cates = GoodsCategoryService::getCates();
        //获取当前id的所有下级id
        $ids = GoodsCategoryService::getChilds($cates,$id);
        //此时ids如果有值 则代表该分类下有子分类
        if(!empty($ids)){
            return $this->error('该分类下存在子分类，无法删除');
        }

        try{
            $flag = GoodsCategoryService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/admin/goodscategory/list'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function getCategoryTree()
    {
        $res = GoodsCategoryService::getCategoryTreeAdmin();

        return $res;
    }
}
