<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\CommonService;
use App\Repositories\AdminLogRepository;
<<<<<<< HEAD:app/Services/AdminLogService.php
class AdminLogService
=======
class AdminLogService extends CommonService
>>>>>>> 039764dbb692d11bb288c6921e8081269efa3aaf:app/Services/AdminLogService.php
{
    use BaseService;

    public static function create($data)
    {
        return AdminLogRepository::create($data);
    }

}