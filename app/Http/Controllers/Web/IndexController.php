<?php

namespace App\Http\Controllers\Web;
use App\Repositories\GoodsCategoryRepo;
use App\Repositories\RegionRepo;
use App\Services\ActivityPromoteService;
use App\Services\AdService;
use App\Services\ArticleService;
use App\Services\BrandService;
use App\Services\CartService;
use App\Services\FriendLinkService;
use App\Services\GoodsCategoryService;
use App\Services\OrderInfoService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\IndexService;
use App\Http\Controllers\Controller;
use App\Services\ShopGoodsQuoteService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function index(Request $request){
        $now = Carbon::now();
        //获取顶部广告
        $top_ad = AdService::getAdvertList(
            ['pageSize'=>1,'page'=>1,'orderType'=>['sort_order'=>'asc']],
            ['position_id'=>2,'enabled'=>1, 'start_time|<='=>$now, 'end_time|>=' => $now]
        );
        if(empty($top_ad['list'])){
            $top_ad=$top_ad['list'];
        }else{
            $top_ad=$top_ad['list'][0];
        }
        //dd(strlen($top_ad['list'][0]['ad_link']));
        //获取大轮播图
        $banner_ad = AdService::getActiveAdvertListByPosition(1);
        //获取订单状态数
        $deputy_user = session('_curr_deputy_user');
        if($deputy_user['is_firm']){
            $firm_id = $deputy_user['firm_id'];
            $status = OrderInfoService::getOrderStatusCount(0, $firm_id);
        }else{
            $status = OrderInfoService::getOrderStatusCount($deputy_user['firm_id'], 0);
        }

        //获取活动
        $promote_list = ActivityPromoteService::getList(['status'=>3,'end_time'=>1], 1, 2);

        //成交动态 假数据 暂时定为$trans_type=1 时为开启创建并显示假数据 暂时创建的是8点到18点之间的数据 缓存有效期一天
        $trans_type = getConfig('open_trans_flow');
        $trans_false_list = [];
        $before_trans_false_list = [];
        if($trans_type == 1){
            $day = date('Ymd');
            $cache_name = $day.'TRANS';
            if(Cache::has($cache_name)){
                $trans_false_list = Cache::get($cache_name);
            }else{//没有缓存 创建假数据
                $trans_false_list = IndexService::createFalseData();
                Cache::add($cache_name,$trans_false_list, 60*24*2);
            }
            //取前一天的数据
            $before_day = date('Ymd',strtotime('-1 day'));
            $before_cache_name = $before_day.'TRANS';
            if(Cache::has($before_cache_name)){
                $before_trans_false_list = Cache::get($before_cache_name);
            }
        }
        //成交动态 真实数据
        $trans_list = OrderInfoService::getOrderGoods([], 1, 10);
        //合并真假数据
        $merge_trans_list = array_merge($trans_list['list'],$trans_false_list,$before_trans_false_list);
        //把合并的数据按照
        array_multisort(array_column($merge_trans_list,'add_time'),SORT_DESC,$merge_trans_list);

        //自营报价 取分类排序前三
        $cat_info = GoodsCategoryService::getCatesThree(['is_delete'=>0,'parent_id'=>0]);
        if(!empty($cat_info)){
            foreach ($cat_info as $k=>$v){
                $condition = [];
                $c = [];
                $c['opt'] = 'OR';
                $c['g.cat_id'] = $v['id'];
                $c['cat.parent_id'] = $v['id'];
                $c['cat2.parent_id'] = $v['id'];
                $condition[] = $c;
                $condition['b.is_self_run'] = 1;
                $condition['b.type'] = 1;
                $condition['b.is_delete'] = 0;
                $condition['b.add_time|>='] = date("Y-m-d",strtotime("-1 day"));
                $cat_info[$k]['quote'] = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>10,'page'=>1],$condition);
            }
        }

//        $goodsList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>10,'page'=>1],['b.is_self_run'=>1,'b.type'=>'1','b.is_delete'=>0]);

        //品牌直营
        $goodsList_brand = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>5,'page'=>1],['b.is_self_run'=>1,'b.type'=>'2','b.is_delete'=>0,'b.add_time|>='=>date("Y-m-d",strtotime("-1 day"))]);
        //获取供应商
        $shops = ShopGoodsQuoteService::getShopOrderByQuote(5);
        //获取资讯
        $article_list = ArticleService::getIndexNews(1,7,['add_time'=>'desc']);
        //dd($article_list);
        //合作品牌
        $brand_list = BrandService::getBrandList(['pageSize'=>12, 'page'=>1,'orderType'=>['sort_order'=>'desc']], ['is_recommend'=> 1,'is_delete'=>0])['list'];

        $friend_link = FriendLinkService::getAllLink();
        return $this->display('web.index',['banner_ad' => $banner_ad, 'order_status'=>$status, 'cat_info'=>$cat_info,'goodsList_brand'=>$goodsList_brand, 'promote_list'=>$promote_list['list'],
            'trans_list'=>$merge_trans_list, 'shops'=>$shops,'article_list'=>$article_list, 'brand_list'=>$brand_list,'top_ad'=>$top_ad,'friend_link'=>$friend_link]);
    }

    //选择公司
    public function changeDeputy(Request $request){
        //$user_id 0 个人
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
            if(!empty(session('cartSession'))){
                session()->forget('cartSession');
            }
            if (!empty(session('invoiceSession'))){
                session()->forget('invoiceSession');
            }
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
                    if(!empty(session('cartSession'))){
                        session()->forget('cartSession');
                    }
                    if (!empty(session('invoiceSession'))){
                        session()->forget('invoiceSession');
                    }
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

    /** 语言切换
     * @param Request $request
     */
    public function edit_language(Request $request){

        if($request->ajax()){

            $data = $request->all();

            App::setLocale($data['lang']);

            $request->session()->put('lang',$data['lang']);

            echo json_encode(['status'=>200,'msg'=>'OK']);

        }

    }
}
