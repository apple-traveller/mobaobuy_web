<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Admin\UserService;
use App\Services\Admin\UserLogService;
use App\Http\Controllers\ExcelController;
class UserController extends Controller
{
    //用户列表
    public function list(Request $request)
    {
        $user_name = $request->input('user_name','');
        $pageSize =config('website.pageSize');
        $users = UserService::getUserList($pageSize,$user_name);
        $userCount = UserService::getCount($user_name);
        //dd($users);
        return $this->display('admin.user.list',['users'=>$users,'user_name'=>$user_name,'userCount'=>$userCount]);
    }

    //编辑(修改状态)
    public function modify(Request $request)
    {
        $id = $request->input("id");
        $is_freeze = $request->input("is_freeze");
        $user = UserService::modify($id,['is_freeze'=>$is_freeze]);
        //print_r($flag);die;
        if($user){
            return $this->result($user['is_freeze'],'1',"修改成功");
        }else{
           return  $this->result('','0',"修改失败");
        }
    }

    //查看详情信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $info = UserService::getInfo($id);
        return $this->display('admin.user.detail',['info'=>$info]);
    }

    //查询用户日志
    public function log(Request $request)
    {
        $pageSize = config('website.pageSize');
        $id = $request->input('id');
        $logs = UserLogService::getLogs($id,$pageSize);
        $logCount = UserLogService::getLogCount($id);
        //dd($logs);
        return $this->display('admin.user.logdetail',['logs'=>$logs,'id'=>$id,'logCount'=>$logCount]);
    }

    //用户添加
    public function addForm()
    {
        return $this->display('admin.user.add');
    }

    //用户添加
    public function add(Request $request)
    {
        $data = array();
        $errorMsg = array();
        $data['user_name']=$request->input('user_name');
        $data['nick_name']=$request->input('nick_name');
        $data['email']=$request->input('email');
        $data['birthday']=$request->input('birthday');
        $data['password']=bcrypt($request->input('password'));
        $data['id_card']=$request->input('id_card');
        $data['front_of_id_card']=$request->input('front_of_id_card');
        $data['reverse_of_id_card']=$request->input('reverse_of_id_card');
        $data['sex']=$request->input('sex');
        $data['is_freeze']=0;
        $data['reg_time']=Carbon::now();
        if(empty($data['user_name'])){
            $errorMsg[] = '账号不能为空';
        }
        if(empty($data['password'])){
            $errorMsg[] = '密码不能为空';
        }

        try{
            $userInfo = UserService::create($data);
            if(!$userInfo){
                return $this->error('添加失败');
            }else{
                return $this->success('添加成功',url('/user/list'));
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //导出用户表
    public static function export()
    {
        $excel = new ExcelController();
        $data = array();
        $data = [
            ['ID','用户名','昵称','邮箱','性别','注册时间','身份证号']
        ];
        $users = UserService::getUsers(['id','user_name','nick_name','email','sex','reg_time','id_card']);
        foreach($users as $item){
            $data[]=$item;
        }
        $excel->export($data,'会员表');
    }

}
