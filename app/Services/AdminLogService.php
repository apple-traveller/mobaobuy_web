<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\CommonService;
use App\Repositories\AdminLogRepository;
class AdminLogService extends CommonService
{

    public static function create($data)
    {
        return AdminLogRepository::create($data);
    }

}