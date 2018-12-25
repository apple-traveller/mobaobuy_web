<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-17
 * Time: 10:53
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\RecruitRepo;
use App\Services\RecruitService;
use Illuminate\Http\Request;

class RecruitController extends Controller
{
    /**
     * 招聘列表
     */
    public function recruitList(Request $request){
        $currpage = $request->input('currpage',1);
        $pageSize = 5;
        $condition = [];
        $condition['is_show'] = 1;
        try{
            $recruitInfo = RecruitService::recruitList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
            return $this->display('web.recruit.recruit',['place'=>$recruitInfo['place'],'recruitInfo'=>$recruitInfo['recruitInfo'],'pageSize'=>$pageSize,'currpage'=>$currpage]);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 招聘详情
     */
    public function recruitDetail($recruitId){
        $condition = [];
        $condition['id'] = $recruitId;
       try{
            $recruitDetail =  RecruitService::recruitDetail($condition);
            return $this->display('web.recruit.recruitDetail',['recruitDetail'=>$recruitDetail]);
       }catch (\Exception $e){
           return $this->error($e->getMessage());
       }
    }
}
