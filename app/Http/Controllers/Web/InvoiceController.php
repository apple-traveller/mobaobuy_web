<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-30
 * Time: 14:36
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function invoiceList(Request $request)
    {
        return $this->display('web.user.invoice');
    }
}
