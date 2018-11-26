<?php

namespace App\Repositories;

class UserWholeSingleRepo
{
    use CommonRepo;

    public static function addClickCount($id){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->where('id',$id)->increment('click_count');
    }
}

