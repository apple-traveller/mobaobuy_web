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
        if(!preg_match("/^1[34578]{1}\\d{9}$/",$data['contact_info'])){
            return $this->error('手机号码有误!');
        }
        if(empty($data['desc'])){
            return $this->error('需求内容不能为空!');
        }

        DemandService::create($data);
        $this->sms_listen_demand($data['contact_info']);
        return $this->success('需求信息提交成功，请耐心等待客服联系！');
    }

    //短信通知(用户提交需求)
    public function sms_listen_demand($accountName){
        if(!empty(getConfig('remind_mobile')) && getConfig('open_user_demand')){
            createEvent('sendSms', ['phoneNumbers'=>getConfig('remind_mobile'), 'type'=>'sms_listen_demand', 'tempParams'=>['phone'=>$accountName]]);
        }
    }
}
