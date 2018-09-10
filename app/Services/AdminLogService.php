<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;
use App\Services\BaseService;
use App\Repositories\AdminLogRepository;
class AdminLogService
{
    use BaseService;

    public static function create($data)
    {
        return AdminLogRepository::create($data);
    }

}