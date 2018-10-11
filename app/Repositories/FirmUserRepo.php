<?php

namespace App\Repositories;

class FirmUserRepo
{
    use CommonRepo;

    public static function firmUserList($firmId){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->where('firm_id',$firmId)->paginate(10);
    }

}
