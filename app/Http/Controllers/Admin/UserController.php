<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\UserRealService;
use App\Services\UserLoginService;
use App\Services\UserService;
use App\Services\UserAddressService;
use App\Services\RegionService;
use App\Services\UserAccountLogService;
use App\Http\Controllers\ExcelController;
use App\Services\FirmStockService;
class UserController extends Controller
{
    //用户列表
    public function list(Request $request)
    {
        $user_name = $request->input('user_name','');
        $currpage = $request->input("currpage",1);
        $is_firm = $request->input('is_firm',2);
        $condition = [];
        if($is_firm!=2){
            $user_ids = UserService::getUserIds($is_firm);
            $condition['id'] = implode('|',$user_ids);
        }
        if(!empty($user_name)){
            $condition['user_name'] = "%".$user_name."%";
        }
        $pageSize = 10;
        $users = UserService::getUserList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['reg_time'=>'desc']],$condition);
        return $this->display('admin.user.list',[
            'users'=>$users['list'],
            'user_name'=>$user_name,
            'userCount'=>$users['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'is_firm'=>$is_firm
        ]);
    }

    //开关修改用户状态
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

    //修改真实姓名
    public function modifyRealName(Request $request)
    {
        $data = [
            'user_id'=>$request->input('id'),
            'real_name'=>$request->input('val'),
        ];
        try{
            $flag = UserRealService::modify($data);
            return $this->result($flag['real_name'],200,'修改成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //修改订单是否需审批字段
    public function modifyNeedApproval(Request $request)
    {
        $data = [
            'id'=>$request->input('id'),
            'need_approval'=>$request->input('need_approval'),
        ];
        try{
            $flag = UserService::modifyNeedApproval($data);
            return $this->result('',200,'修改成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //查看详情信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $is_firm = $request->input('is_firm',2); //实名状态
        $currpage = $request->input('currpage',1);
        $info = UserService::getUserInfo($id);//基本信息
        $user_address = UserAddressService::getInfoByUserId($id);//收货地址列表
        $user_collect_goods = UserService::getCollectGoods($id);
        $region = RegionService::getList($pager=[],$condition=[]);
        return $this->display('admin.user.detail',
            [ 'info'=>$info,
              'user_address'=>$user_address,
              'region'=>$region,
              'currpage'=>$currpage,
              'is_firm'=>$is_firm,
              'user_collect_goods'=>$user_collect_goods
            ]);
    }

    //查询用户日志
    public function log(Request $request)
    {
        $pageSize = 10;
        $pcurrpage = $request->input("pcurrpage");//用户列表当前页
        $is_firm = $request->input('is_firm');
        $id = $request->input('id');
        $currpage = $request->input("currpage",1);
        $condition=['user_id'=>$id];
        $logs = UserLoginService::getUserLogs(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['log_time'=>'desc']],$condition);
        //dd($logs);
        return $this->display('admin.user.logdetail',[
            'logs'=>$logs['list'],
            'id'=>$id,
            'logCount'=>$logs['total'],
            'pcurrpage'=>$pcurrpage,
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'is_firm'=>$is_firm
        ]);
    }

    //查看实名信息
    public function userRealForm(Request $request)
    {
        $userid = $request->input('id');
        $is_firm = $request->input('is_firm',""); //实名状态
        $currpage = $request->input("currpage");
        $info = UserRealService::getInfoByUserId($userid);
        if(empty($info)){
            return $this->error("该用户未提交实名信息");
        }
        return $this->display("admin.user.userreal",[
            'info'=>$info,
            'is_firm'=>$is_firm,
            'currpage'=>$currpage,
            'userid'=>$userid,
        ]);
    }

    //实名审核
    public function userReal(Request $request)
    {
        $data = $request->all();
        $data['review_time'] = Carbon::now();
        try{
            $user = UserRealService::modifyReviewStatus($data);
            return $this->success("审核成功","",$user);
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
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
        $is_firm = $request->input('is_firm',2); //实名状态
        $currpage = $request->input('currpage',1);
        $pcurrpage = $request->input('pcurrpage');//用户列表当前页
        $pageSize = 10;
        $condition = ['user_id'=>$id];
        $info = UserAccountLogService::getInfoByUserId(['pageSize'=>$pageSize,'page'=>$currpage],$condition);//分页
        return $this->display('admin.user.points',[
            'info'=>$info['list'],
            'pcurrpage'=>$pcurrpage,
            'pageSize'=>$pageSize,
            'totalcount'=>$info['total'],
            'currpage'=>$currpage,
            'is_firm'=>$is_firm,
            'id'=>$id
        ]);
    }

    //企业库存
    public function firmStock(Request $request)
    {
        $firm_id = $request->input('firm_id');
        $pcurrpage = $request->input('pcurrpage');
        $is_firm = $request->input('is_firm',2);
        $currpage = $request->input('currpage',1);
        $pageSize = 10;
        $condition = ['firm_id'=>$firm_id];
        $firm_stocks = FirmStockService::getFirmStocksByFirmId(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['id'=>'asc']],$condition);
        return $this->display('admin.user.firmstock',[
            'firm_stocks'=>$firm_stocks['list'],
            'total'=>$firm_stocks['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'pcurrpage'=>$pcurrpage,
            'is_firm'=>$is_firm,
            'firm_id'=>$firm_id
        ]);
    }

    //企业库存流水
    public function firmStockFlow(Request $request)
    {
        $data = $request->all();
        $currpage = $request->input("currpage",1);
        $pageSize = 8;
        $condition=[
            'firm_id'=>$data['firm_id'],
            'goods_id'=>$data['goods_id']
        ];
        $firm_stock_flows = FirmStockService::getStockFlowList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['flow_time'=>'desc']],$condition);
        if(empty($firm_stock_flows['list'])){
            return $this->result("",400,'无信息');
        }else{
            return $this->result(['list'=>$firm_stock_flows['list'],'currpage'=>$currpage,'total'=>$firm_stock_flows['total'],'pageSize'=>$pageSize],200,'success');
        }
    }


    //添加用户
    public function addForm(Request $request)
    {
        return $this->display('admin.user.add');
    }

    //保存用户
    public function save(Request $request)
    {
        $data = $request->all();
        $errorMsg = [];
        if(empty($data['user_name'])){
            $errorMsg[] = '登录名不能为空';
        }
        if(empty($data['password'])){
            $errorMsg[] = '密码不能为空';
        }
        $data['is_firm'] = 0;
        $data['email'] = $this->requestGetNotNull('email'," ");
        if(!empty($errorMsg)){
            return $this->error(implode("|",$errorMsg));
        }
        try{
            $flag = UserService::userRegister($data);
            if(!empty($flag)){
                return $this->success('添加成功',url('/admin/user/list'));
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //添加实名认证信息
    public function addUserRealForm(Request $request)
    {
        return $this->display('admin.user.adduserreal');
    }


}
