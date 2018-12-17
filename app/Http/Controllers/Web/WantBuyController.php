<?php

namespace App\Http\Controllers\Web;
use App\Services\InquireService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\WantBuyService;

class WantBuyController extends Controller
{
    /**求购页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wantBuyList(Request $request){
        $currpage = $request->input('currpage',1);
        $pageSize = 1;
        $inquireList = InquireService::inquireList(['pageSize' => $pageSize, 'page' => $currpage]);
        return $this->display('web.wantbuy.wantBuy',['inquireList'=>$inquireList,'pageSize'=>$pageSize,'currpage'=>$currpage]);
    }




}
