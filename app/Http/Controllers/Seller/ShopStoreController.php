<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-13
 * Time: 20:48
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopStoreController extends Controller
{
    public function getList(Request $request)
    {
        return $this->display('seller.shop.store');
    }
}
