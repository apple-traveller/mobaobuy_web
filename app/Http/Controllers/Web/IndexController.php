<?php

namespace App\Http\Controllers\Web;
use App\Repositories\RegionRepository;
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

    public function  index(){

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
        $this->display('web',compact(['city','cityInfo']));
    }

    //修改定位城市
    public function updateCity(Request $request){
        $city = $request->input('city');
        session()->put('selCity',$city);
    }
}
