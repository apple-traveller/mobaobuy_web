<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\ShopService;
use App\Services\RecruitService;
class RecruitController extends Controller
{
    //列表
    public function index(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $pageSize = $request->input('pageSize',10);
        $condition = ['is_show'=>1];
        $recruits = RecruitService::getRecruitList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        return $this->display('admin.recruit.list',[
            'total'=>$recruits['total'],
            'recruits'=>$recruits['list'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize
        ]);
    }

    //添加
    public function add(Request $request)
    {
        return $this->display('admin.recruit.add');
    }

    //编辑
    public function edit(Request $request)
    {
        $id = $request->input("id");
        $currpage = $request->input('currpage',1);
        $recruit = RecruitService::getRecruitInfo($id);
        return $this->display('admin.recruit.edit',[
            'recruit'=>$recruit,
            'currpage'=>$currpage
        ]);
    }

    //是否显示
    public function isShow(Request $request)
    {
        $id = $request->input("id");
        $is_show = $request->input("val", 0);
        try{
            RecruitService::modify(['id'=>$id, 'is_show' => $is_show]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //保存
    public function save(Request $request)
    {
        $data = [
            'recruit_job'=>$request->input("recruit_job"),
            'recruit_number'=>$request->input("recruit_number"),
            'recruit_place'=>$request->input("recruit_place"),
            'recruit_firm'=>$request->input("recruit_firm"),
            'recruit_pay'=>$request->input("recruit_pay"),
            'recruit_address'=>$request->input("recruit_address"),
            'recruit_user'=>$this->requestGetNotNull('recruit_user'),
            'recruit_mobile'=>$this->requestGetNotNull('recruit_mobile'),
            'working_experience'=>$request->input("working_experience"),
            'education'=>$request->input("education"),
            'recruit_type'=>$request->input("recruit_type"),
            'job_desc'=>$request->input("job_desc"),
            'id'=>$request->input('id',""),
            'recruit_branch'=>$request->input('recruit_branch'),
            'job_type'=>$request->input('job_type'),
            'currpage'=>$request->input('currpage',1),
        ];

        $currpage = $data['currpage'];
        unset($data['currpage']);
        $errorMsg = [];
        if(empty($data['recruit_job'])){
            $errorMsg[] = '招聘职位不能为空';
        }
        if(empty($data['recruit_place'])){
            $errorMsg[] = '工作地点不能为空';
        }
        if(empty($data['recruit_type'])){
            $errorMsg[] = '工作类型不能为空';
        }
        if(empty($data['job_type'])){
            $errorMsg[] = '职位类别不能为空';
        }
        if(empty($data['job_desc'])){
            $errorMsg[] = '岗位职责不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        try{
            if(empty($data['id'])){
                RecruitService::uniqueValidate($data['recruit_job']);//唯一性验证
                $info = RecruitService::create($data);
            }else{
                $info = RecruitService::modify($data);
            }
            if(empty($info)){
                return $this->error('保存失败');
            }
            return $this->success('保存成功！',url("/admin/recruit/list")."?currpage=".$currpage);
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = RecruitService::delete($id);
            if($flag){
                return $this->success('删除成功',url("/admin/recruit/list"));
            }else{
                return $this->error('删除失败');
            }

        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除招聘简历
     *
     */
    public function deleteResume(Request $request){
        $id = $request->input('id');
        try{
            $flag = recruitService::deleteResume($id);
            if($flag){
                return $this->success('删除成功', url("/admin/resume/list"));
            }
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 招聘简历列表
     */
    public function resumeList(Request $request){
        $currpage = $request->input('currpage',1);
        $pageSize = $request->input('pageSize',10);
        try{
            $resumeInfo = RecruitService::resumeList(['pageSize'=>$pageSize,'page'=>$currpage],[]);
            return $this->display('admin.resume.list',[
                'total'=>$resumeInfo['total'],
                'resumes'=>$resumeInfo['list'],
                'currpage'=>$currpage,
                'pageSize'=>$pageSize
            ]);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
