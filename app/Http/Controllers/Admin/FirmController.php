<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirmService;
use App\Services\FirmLogService;
use App\Http\Controllers\ExcelController;
class FirmController extends Controller
{
    //企业列表
    public function list(Request $request)
    {
        $firm_name = $request->input('firm_name','');
        $pageSize = config('website.pageSize');
        $firms = FirmService::getFirmList($pageSize,$firm_name);
        $firmCount = FirmService::getCount($firm_name);
        //dd($firmCount);
        return $this->display('admin.firm.list',['firms'=>$firms,'firm_name'=>$firm_name,"firmCount"=>$firmCount]);
    }

    //编辑(修改状态)
    public function modify(Request $request)
    {
        $id = $request->input("id");
        $is_freeze = $request->input("is_freeze");

        try{
            $firm = FirmService::modify($id,['is_freeze'=>$is_freeze]);
            if($firm){
                return $this->result($firm['is_freeze'],'1',"修改成功");
            }else{
                return  $this->result('','0',"修改失败");
            }
        }catch(\Exception $e){
            return  $this->result('','0',$e->getMessage());
        }
    }

    //查看详情信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $info = FirmService::getInfo($id);
        return $this->display('admin.firm.detail',['info'=>$info]);
    }

    //查看企业积分信息
    public function pointflow(Request $request)
    {
        $firm_id = $request->input('firm_id');
        $points = FirmService::getPointsByFirmid($firm_id);
        //dd($points);
        return $this->display('admin.firm.pointflow',['points'=>$points]);
    }

    public function firmuser(Request $request)
    {
        $firm_id = $request->input('firm_id');
        $firmusers = FirmService::getFirmUser($firm_id);
        return $this->display('admin.firm.firmuser',['firmusers'=>$firmusers]);
    }


    //查询用户日志
    public function log(Request $request)
    {
        $pageSize = config('website.pageSize');
        $id = $request->input('id');
        $logs = FirmLogService::getLogInfo($id,$pageSize);
        $logCount = FirmLogService::getLogCount($id);
        return $this->display('admin.firm.log',['logs'=>$logs,'id'=>$id,'logCount'=>$logCount]);
    }


    //导出企业表
    public static function export()
    {
        $excel = new ExcelController();
        $data = array();
        $data = [
            ['ID','企业名称','账号','联系人','联系方式','注册时间','访问次数']
        ];
        $users = FirmService::exportExcel(['id','firm_name','user_name','contactName','contactPhone','reg_time','visit_count']);
        foreach($users as $item){
            $data[]=$item;
        }
        $excel->export($data,'会员表');
    }

}
