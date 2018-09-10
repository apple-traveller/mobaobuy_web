<?php

namespace App\Services\Admin;

<<<<<<< HEAD:app/Services/FirmLogService.php
use App\Services\BaseService;
use App\Repositories\FirmLogRepository;
class FirmLogService
=======
use App\Services\CommonService;
use App\Repositories\FirmLogRepo;
class FirmLogService extends CommonService
>>>>>>> 039764dbb692d11bb288c6921e8081269efa3aaf:app/Services/Admin/FirmLogService.php
{
    use BaseService;
    //获取日志信息
    public static function getLogInfo($id,$pageSize)
    {
        return FirmLogRepo::getLogInfo($id,$pageSize);
    }

    //获取日志总条数
    public static function getLogCount($id)
    {
        return FirmLogRepo::getLogCount($id);
    }
   


}