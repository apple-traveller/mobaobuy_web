<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\ArticleService;
use App\Services\Admin\ArticleCatService;
use Illuminate\Support\Carbon;

class ArticleController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $cat_id = $request->input('cat_id',0);
        $title = $request->input('title',"");
        $pageSize =config('website.pageSize');//分页
        //查询所有的分类
        $cates = ArticleCatService::getCates();
        $cateTrees = ArticleCatService::getCatesTree($cates);
        //查询所有文章
        $articles = ArticleService::getList($cat_id,$pageSize,$title);
        //查询文章总条数
        $count = ArticleService::getCount($cat_id,$title);
        //dd($articles);
        return $this->display('admin.article.list',
            [
                'cateTrees'=>$cateTrees,
                'articles'=>$articles,
                'count'=>$count,
                'title'=>$title,
                'cat_id'=>$cat_id
            ]);
    }

    //添加
    public function addForm(Request $request)
    {
        //查询所有的分类
        $cates = ArticleCatService::getCates();
        $cateTrees = ArticleCatService::getCatesTree($cates);
        return $this->display('admin.article.add',
            [
                'cateTrees'=>$cateTrees,
            ]);
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        //查询所有的分类
        $cates = ArticleCatService::getCates();
        $cateTrees = ArticleCatService::getCatesTree($cates);
        //查询
        $article = ArticleService::getInfo($id);
        return $this->display('admin.article.edit',
            [
                'cateTrees'=>$cateTrees,
                'article'=>$article
            ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $id = $request->input('id');
        unset($data['_token']);
        $errorMsg = [];
        //dd($data);
        if(empty($data['title'])){
            $errorMsg[] = '文章标题不能为空';
        }
        if(empty($data['content'])){
            $errorMsg[] = '文章内容不能为空';
        }
        if(empty($data['author'])){
            $errorMsg[] = '文章作者不能为空';
        }
        if(empty($data['keywords'])){
            $errorMsg[] = '文章关键字不能为空';
        }
        if(empty($data['cat_id'])){
            $errorMsg[] = '所属分类不能为空';
        }
        if(empty($data['image'])){
            $errorMsg[] = '图片不能为空';
        }

        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        try{
            if(empty($id)){
                ArticleService::uniqueValidate($data['title']);//唯一性验证
                $data['add_time']=Carbon::now();
                //$data['content']=htmlspecialchars($data['content']);
                //dd($data);
                $info = ArticleService::create($data);
            }else{
                $info = ArticleService::modify($id,$data);
            }
            if(!$info){
                return $this->error('保存失败');
            }
            return $this->success('保存成功！',url("/article/list"));
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function detail(Request $request)
    {
        $id = $request->input('id');
        //查询所有的分类
        $cates = ArticleCatService::getCates();
        $cateTrees = ArticleCatService::getCatesTree($cates);
        //查询
        $article = ArticleService::getInfo($id);
        return $this->display('admin.article.detail',
            [
                'cateTrees'=>$cateTrees,
                'article'=>$article
            ]);
    }

    //排序
    public function sort(Request $request)
    {
        $id = $request->input('id');
        $sort_order = $request->input('sort_order');
        try{
            $info = ArticleService::modify($id,['sort_order'=>$sort_order]);
            if(!$info){
                return $this->result('',400,'更新失败');
            }
            return $this->result("/article/list",200,'更新成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');

        try{
            $flag = ArticleService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/article/list'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //ajax修改状态
    public function status(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $id = $request->input('id');
        try{
            $info = ArticleService::modify($id,$data);
            if($info){
                return $this->result($info['is_show'],200,"修改成功");
            }else{
                return  $this->result('',400,"修改失败");
            }
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }

    }
}