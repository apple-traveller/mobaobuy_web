<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\LogisticsService;
class LogisticsController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pagesize = $request->input("pagesize",10);

    }
}
