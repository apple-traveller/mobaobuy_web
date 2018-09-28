<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-27
 * Time: 10:28
 */
namespace App\Services;

use App\Repositories\ShopLogRepo;

class ShopLogService
{
    use CommonService;

    public static function create($data)
    {
        return ShopLogRepo::create($data);
    }
}
