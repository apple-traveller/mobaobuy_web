<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\AdminLogRepo;

class AdminLogService
{
    use CommonService;

    public static function create($data)
    {
        return AdminLogRepo::create($data);
    }

}