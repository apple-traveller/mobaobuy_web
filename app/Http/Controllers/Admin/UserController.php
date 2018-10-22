<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\UserRealService;
use App\Services\UserLoginService;
use App\Services\UserService;
use App\Services\UserInvoicesService;
use App\Services\UserAddressService;
use App\Services\RegionService;
use App\Services\UserAccountLogService;
use App\Http\Controllers\ExcelController;
class UserController extends Controller
{
    //用户列表
    public function list(Request $request)
    {
        $user_name = $request->input('user_name','');
        $currpage = $request->input("currpage",1);
        $pageSize = 10;
        $is_firm = $request->input('is_firm',0);
        $condition = ['is_firm'=>$is_firm];
        if(!empty($user_name)){
            $condition['user_name'] = "%".$user_name."%";
        }
        $users = UserService::getUserList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        return $this->display('admin.user.list',[
            'users'=>$users['list'],
            'user_name'=>$user_name,
            'userCount'=>$users['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'is_firm'=>$is_firm
        ]);
    }

    public function modifyFreeze(Request $request){
        $id = $request->input("id");
        $is_freeze = $request->input("val", 0);
        try{
            UserService::modify(['id'=>$id,'is_freeze' => $is_freeze]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //用户审核(修改状态)
    public function verifyForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $info = UserService::getInfo($id);
        return $this->display('admin.user.verify',['info'=>$info,'currpage'=>$currpage]);
    }

    //用户审核(修改状态)
    public function verify(Request $request)
    {
        $id = $request->input("id");
        $is_firm = $request->input("is_firm");
        $currpage = $request->input('currpage');
        $data = $request->all();
        $data['is_validated']=1;
        unset($data['currpage']);
        try{
            $user = UserService::modify($data);
            if($user){
                return $this->success("修改成功",url('/admin/user/list')."?is_firm=".$is_firm."&currpage=".$currpage);
            }else{
                return  $this->error("修改失败");
            }
        }catch(\Exception $e){
            return  $this->error('','0',$e->getMessage());
        }
    }

    //查看详情信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $info = UserService::getInfo($id);//基本信息
        $user_invoices = UserInvoicesService::getInfoByUserId($id);//会员发票信息
        $user_address = UserAddressService::getInfoByUserId($id);//收货地址列表
        $region = RegionService::getList($pager=[],$condition=[]);
        return $this->display('admin.user.detail',
            [ 'info'=>$info,
              'user_invoices'=>$user_invoices,
              'user_address'=>$user_address,
              'region'=>$region,
                'currpage'=>$currpage
            ]);
    }

    //查询用户日志
    public function log(Request $request)
    {
        $pageSize = 3;
        $currpage = $request->input("currpage");
        $id = $request->input('id');
        $is_firm = $request->input("is_firm");
        $condition=['user_id'=>$id];
        $logs = UserLoginService::getUserLogs(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['log_time'=>'desc']],$condition);
        //dd($logs);
        return $this->display('admin.user.logdetail',[
            'logs'=>$logs['list'],
            'id'=>$id,
            'logCount'=>$logs['total'],
            'is_firm'=>$is_firm,
            'currpage'=>$currpage,
            'pageSize'=>$pageSize
        ]);
    }

    //查看实名信息
    public function userRealForm(Request $request)
    {
        $userid = $request->input('id');
        $is_firm = $request->input('is_firm');
        $currpage = $request->input("currpage");
        $info = UserRealService::getInfoByUserId($userid);
        if(empty($info)){
            return $this->error("该用户未提交实名信息");
        }
        return $this->display("admin.user.userreal",['info'=>$info,'is_firm'=>$is_firm,'currpage'=>$currpage]);
    }

    //实名审核
    public function userReal(Request $request)
    {
        $id = $request->input("id");
        $is_firm = $request->input("is_firm");
        $currpage = $request->input('currpage');
        $data = $request->all();
        $data['review_time'] = Carbon::now();
        unset($data['is_firm']);
        unset($data['currpage']);
        try{
            $user = UserRealService::modify($data);
            if($user){
                return $this->result(url('/admin/user/list')."?is_firm=".$is_firm."&currpage=".$currpage,1,"修改状态成功");
            }else{
                return  $this->error("修改失败");
            }
        }catch(\Exception $e){
            return  $this->error('',$e->getMessage());
        }
    }

    //导出用户表
    public static function export()
    {
        $excel = new ExcelController();
        $data = array();
        $data = [
            ['ID','用户名','昵称','邮箱','访问次数','注册时间','会员积分']
        ];
        $users = UserService::getUsers(['id','user_name','nick_name','email','visit_count','reg_time','points']);
        foreach($users as $item){
            $data[]=$item;
        }
        $excel->export($data,'会员表');
    }

    //查看企业积分流水
    public function points(Request $request)
    {
        $id = $request->input("id");
        $is_firm = $request->input("is_firm");
        $currpage = $request->input('currpage',1);
        $pageSize = 3;
        $condition = ['user_id'=>$id];
        $info = UserAccountLogService::getInfoByUserId(['pageSize'=>$pageSize,'page'=>$currpage],$condition);//分页
        return $this->display('admin.user.points',[
            'info'=>$info['list'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'totalcount'=>$info['total'],
            'is_firm'=>$is_firm
        ]);
    }

}
