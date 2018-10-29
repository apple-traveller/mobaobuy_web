<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-29
 * Time: 10:47
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function list(Request $request)
    {
        return $this->display('seller.invoice.list');
    }
}
