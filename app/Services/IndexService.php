<?php

namespace App\Services;
use App\Repositories\IndexRepository;
use App\Repositories\RegionRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class IndexService
{
    use CommonService;

    public static function getProvince($city,$region_type){
        return RegionRepository::getProvince($region_type);
    }
}