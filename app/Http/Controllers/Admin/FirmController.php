<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Admin\FirmService;
use App\Http\Controllers\ExcelController;
class FirmController extends Controller
{
    //用户列表
    public function list(Request $request)
    {
        $firm_name = $request->input('firm_name','');
        $pageSize = config('website.pageSize');
        $firms = FirmService::getFirmList($pageSize,$firm_name);
        //dd($firms);
        return $this->display('admin.firm.list',['firms'=>$firms,'firm_name'=>$firm_name]);
    }

    //编辑(修改状态)
    public function modify(Request $request)
    {
        $id = $request->input("id");
        $is_freeze = $request->input("is_freeze");
        $firm = FirmService::modify($id,['is_freeze'=>$is_freeze]);
        //print_r($firm);die;
        if($firm){
            return $this->result($firm['is_freeze'],'1',"修改成功");
        }else{
           return  $this->result('','0',"修改失败");
        }
    }

    //查看详情信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $info = FirmService::getInfo($id);
        return $this->display('admin.firm.detail',['info'=>$info]);
    }

    //查询用户日志
    public function log(Request $request)
    {
        $pageSize = config('website.pageSize');
        $id = $request->input('id');
        $logs = UserService::getLogInfo($id,$pageSize);
        //dd($logs);
        return $this->display('admin.user.logdetail',['logs'=>$logs,'id'=>$id]);
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
