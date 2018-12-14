<?php

namespace App\Http\Controllers\Web;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\WantBuyService;

class WantBuyController extends Controller
{
    public function wantBuyList(){
        return $this->display('web.wantbuy.wantBuy');
    }

}
