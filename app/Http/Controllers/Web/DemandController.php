<?php
namespace App\Http\Controllers\Web;

use App\Services\DemandService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemandController extends Controller
{
    public function addDemand(Request $request){
        if(empty(session('_web_user_id'))){
            $data = [
                'user_id' => 0,
                'contact_info' => $request->input('contact',''),
                'desc' => $request->input('content','')
            ];
        }else{
            $data = [
                'user_id' => session('_web_user_id'),
                'contact_info' => session('_web_user.user_name'),
                'desc' => $request->input('content','')
            ];
        }
        if(empty($data['contact_info'])){
            return $this->error('联系方法不能为空!');
        }
        if(empty($data['desc'])){
            return $this->error('需求内容不能为空!');
        }

        DemandService::create($data);

        return $this->success('需求信息提交成功，请耐心等待客服联系！');
    }
}
