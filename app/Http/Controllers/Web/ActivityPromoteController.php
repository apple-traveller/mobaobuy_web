<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ActivityPromoteService;

class ActivityPromoteController extends Controller
{
    //限时抢购
    public function buyLimit(){
        $review_status = 3;
        try{
            $promoteInfo = ActivityPromoteService::buyLimit($review_status);
            return $this->display('web.goods.buyLimit',compact('promoteInfo'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
   
 
}
