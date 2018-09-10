<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\BaseService;
use App\Repositories\AdminLogRepository;
class AdminLogService extends BaseService
{

    public static function create($data)
    {
        return AdminLogRepository::create($data);
    }

}