<?php

namespace App\Repositories;

class GoodsCategoryRepository
{
    use CommonRepository;

    public static function search($paper=[],$where=[]){
        $clazz = self::getBaseModel();
        return $clazz::query()->paginate(10);
    }
}
