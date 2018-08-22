<?php

namespace App\Services\Web;
use App\Repositories\GoodsCategoryRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GoodsCategoryService extends BaseService
{
    public static function GoodsCategoryInfo($where=[]){
        return GoodsCategoryRepository::search([],$where);
    }

    //分类添加
    public static function categoryCreate($data){
        return GoodsCategoryRepository::create($data);
    }

    //分类编辑
    public static function categoryUpdate($id,$data){
        return GoodsCategoryRepository::modify($id,$data);
    }


}