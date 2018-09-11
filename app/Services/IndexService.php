<?php
namespace App\Services;
use App\Repositories\RegionRepo;
class IndexService
{
    use CommonService;

    public static function getProvince($city,$region_type){
        return RegionRepo::getProvince($region_type);
    }
}