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
        $currpage = $request->input("curr",1);
        $pageSize = 4;
        $is_firm = $request->input('is_firm',0);
        $condition = ['is_firm'=>$is_firm];
        if(!empty($user_name)){
            $condition['user_name'] = $user_name;
        }
        $users = UserService::getUserList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        //dd($users);
        return $this->display('admin.user.list',[
            'users'=>$users['list'],
            'user_name'=>$user_name,
            'userCount'=>$users['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'is_firm'=>$is_firm
        ]);
    }

    //编辑(修改状态)
    public function modify(Request $request)
    {
        $id = $request->input("id");
        $data = $request->all();
        unset($data['_token']);
        try{
            $user = UserService::modify($id,$data);
            if($user){
                return $this->result($user['is_freeze'],'1',"修改成功");
            }else{
                return  $this->result('','0',"修改失败");
            }
        }catch(\Exception $e){
            return  $this->result('','0',$e->getMessage());
        }
    }


    //用户审核(修改状态)
    public function verifyForm(Request $request)
    {
        $id = $request->input('id');
        $info = UserService::getInfo($id);
        return $this->display('admin.user.verify',['info'=>$info]);
    }

    //用户审核(修改状态)
    public function verify(Request $request)
    {
        $id = $request->input("id");
        $is_firm = $request->input("is_firm");
        $data = $request->all();
        $data['is_validated']=$data['is_validated']==1?0:1;
        //dd($data);
        unset($data['_token']);
        try{
            $user = UserService::modify($id,$data);
            if($user){
                return $this->success("修改成功",url('/user/list')."?is_firm=".$is_firm);
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
        $info = UserService::getInfo($id);//基本信息
        $user_invoices = UserInvoicesService::getInfoByUserId($id);//会员发票信息
        $user_address = UserAddressService::getInfoByUserId($id);//收货地址列表
        $region = RegionService::getList($pager=[],$condition=[]);
        //dd($region);
        return $this->display('admin.user.detail',
            [ 'info'=>$info,
              'user_invoices'=>$user_invoices,
              'user_address'=>$user_address,
              'region'=>$region
            ]);
    }

    //查询用户日志
    public function log(Request $request)
    {
        $pageSize = config('website.pageSize');
        $id = $request->input('id');
        $is_firm = $request->input("is_firm");
        $logs = UserLoginService::getLogs($id,$pageSize);
        $logCount = UserLoginService::getLogCount($id);
        //dd($logs);
        return $this->display('admin.user.logdetail',['logs'=>$logs,'id'=>$id,'logCount'=>$logCount,'is_firm'=>$is_firm]);
    }

    //查看实名信息
    public function userRealForm(Request $request)
    {
        $userid = $request->input('id');
        $is_firm = $request->input('is_firm');
        $info = UserRealService::getInfoByUserId($userid);
        if(empty($info)){
            return $this->error("该用户未提交实名信息");
        }
        return $this->display("admin.user.userreal",['info'=>$info,'is_firm'=>$is_firm]);
    }

    //实名审核
    public function userReal(Request $request)
    {
        $id = $request->input("id");
        $is_firm = $request->input("is_firm");
        $data = $request->all();
        $data['review_time'] = Carbon::now();
        $data['review_status']=$data['review_status']==2?1:2;
        //dd($data);
        unset($data['_token']);
        unset($data['is_firm']);
        try{
            $user = UserRealService::modify($id,$data);
            if($user){
                return $this->success("修改成功",url('/user/list')."?is_firm=".$is_firm);
            }else{
                return  $this->error("修改失败");
            }
        }catch(\Exception $e){
            return  $this->error('','0',$e->getMessage());
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
        $currpage = $request->input('curr',1);
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
