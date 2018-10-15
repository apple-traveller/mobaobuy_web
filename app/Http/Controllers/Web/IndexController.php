<?php

namespace App\Http\Controllers\Web;
use App\Repositories\RegionRepo;
use Illuminate\Http\Request;
use App\Services\IndexService;
use App\Http\Controllers\Controller;



class IndexController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function  index(Request $request){
        $id = session('_web_user_id');
        if($request->isMethod('get')){
            //个人绑定的公司信息
            if(!session('_web_user')['is_firm']){
                try{
                    $firmInfo = IndexService::getUserInfoByFirmId($id);
                    $articleCat = IndexService::information();
                }catch(\Exception $e){
                    return $this->error();
                }
            }
            $userId = session('userId');
            return $this->display('web.index',compact('articleCat','firmInfo','userId'));
        }
    }

    //选择公司
    public function selectCompany(Request $request){
        $user_id = $request->input('user_id');
        session()->put('userId',$user_id);
        if($user_id){
            session()->put('_web_firm_id',$user_id);
            return $this->success();
        }
        session()->forget('_web_firm_id');
        return $this->success();
    }

    //首页定位城市
    public function getCity(Request $request){
        $city = session('selCity');
        $cityInfo = session('cityInfo');
        if($city && $cityInfo){
            $this->display('web',['city','cityInfo']);return;
        }
        $ip = $request->getClientIp();
        $json=file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
        $arr=json_decode($json);
        $province =  $arr->data->region;    //省份
        $city = $arr->data->city;    //城市
        $region_type = 1;
        $cityInfo = IndexService::getProvince($city,$region_type);
        session()->put('selCity',$city);
        session()->put('cityInfo',$cityInfo);
        return $this->display('web',compact(['city','cityInfo']));
    }

    //修改定位城市
    public function updateCity(Request $request){
        $city = $request->input('city');
        session()->put('selCity',$city);
    }

    //咨询分类
    public function article($id){
        $articleInfo = IndexService::article($id);
        return $this->display('web.user.articleDetails',compact('articleInfo'));
    }
}
