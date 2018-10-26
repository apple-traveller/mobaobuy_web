<?php

namespace App\Http\Controllers\Web;
use App\Repositories\GoodsCategoryRepo;
use App\Repositories\RegionRepo;
use App\Services\GoodsCategoryService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Services\IndexService;
use App\Http\Controllers\Controller;
use App\Services\ShopGoodsQuoteService;


class IndexController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function  index(Request $request){
        $currpage = $request->input("currpage",1);
        $condition = [];
        $pageSize = 10;
        $goodsList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);

        //获取分类树
        $cat_tree = GoodsCategoryService::getCategoryTree();
        //获取活动
        


        return $this->display('web.index',['goodsList'=>$goodsList['list'], 'cat_tree'=>$cat_tree]);
    }

    //选择公司
    public function changeDeputy(Request $request){
        $user_id = $request->input('user_id', 0);
        if(empty($user_id)){
            //代表自己
            $info = [
                'is_self' => 1,
                'is_firm' => session('_web_user')['is_firm'],
                'firm_id'=> session('_web_user_id'),
                'name' => session('_web_user')['nick_name']
            ];
            session()->put('_curr_deputy_user', $info);
            return $this->success();
        }else{
            //获取用户所代表的公司
            $firms = UserService::getUserFirms(session('_web_user_id'));
            foreach ($firms as $firm){
                if($user_id == $firm['firm_id']){
                    //修改代表信息
                    $firm['is_self'] = 0;
                    $firm['is_firm'] = 1;
                    $firm['firm_id'] = $user_id;
                    $firm['name'] = $firm['firm_name'];
                    session()->put('_curr_deputy_user', $firm);
                    return $this->success();
                }
            }

            //找不到，清空session
            session()->forget('_curr_deputy_user');
            session()->forget('_web_user');
            return $this->success();
        }
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
