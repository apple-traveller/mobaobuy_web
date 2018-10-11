<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-11
 * Time: 17:03
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\SeckillService;
use Illuminate\Http\Request;

class SeckillController extends Controller
{
    public function seckill(Request $request)
    {
        $shop_id = session('_seller')['shop_id'];
    }
}
