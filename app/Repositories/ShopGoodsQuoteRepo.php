<?php
/**
 * Created by PhpStorm.
<<<<<<< HEAD
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ShopGoodsQuoteRepo
{
    use CommonRepo;

    public static function getTopShopWidthUpdate($condition, $top = 10){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        $query = self::setCondition($query, $condition);
        $rs = $query->orderBy('add_time','desc')->groupBy('shop_id')->take($top)->get();
        if($rs){
            return $rs->toArray();
        }
        return [];
    }
    
    //获取报价列表
    public static function goodsQuoteList(){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->paginate(5);
    }

    /**
     * 获取商家报价列表-没有分页
     * @param $shop_id
     * @return mixed
     */
    public static function getQuoteGoods($shop_id)
    {
        $model = self::getBaseModel();
        $list = $model::where('shop_id',$shop_id)->groupBy('goods_id')->get();
        if (!empty($list)){
            return $list->toArray();
        }
    }

    //根据条件获取符合条件的报价分类
    public static function getQuoteCategory($condition){
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $query = \DB::table($clazz->getTable().' as b');
        $query = self::setCondition($query, $condition);
        $cats = $query->join('goods as g', 'b.goods_id', '=', 'g.id')->groupBy('g.cat_id')->select('g.cat_id')->pluck('cat_id');
        if (!empty($cats)){
            return $cats->toArray();
        }
        return [];
    }

    //根据条件获取符合条件的报价品牌
    public static function getQuoteBrand($condition){
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $query = \DB::table($clazz->getTable().' as b');
        $query = self::setCondition($query, $condition);
        $rs = $query->join('goods as g', 'b.goods_id', '=', 'g.id')->groupBy('g.brand_id')->select('g.brand_id')->pluck('brand_id');
        if (!empty($rs)){
            return $rs->toArray();
        }
        return [];
    }

    //根据条件获取符合条件的报价发货地
    public static function getQuoteCity($condition){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        $query = self::setCondition($query, $condition);
        $rs = $query->groupBy('place_id')->pluck('place_id');
        if (!empty($rs)){
            return $rs->toArray();
        }
        return [];
    }
    //根据条件获取报价列表 分页
    public static function getQuoteInfoBySearch($pager,$condition)
    {
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $query = \DB::table($clazz->getTable().' as b')
            ->leftJoin('goods as g', 'b.goods_id', '=', 'g.id')
            ->leftJoin('brand', 'g.brand_id', '=', 'brand.id')
            ->leftJoin('goods_category as cat', 'g.cat_id', '=', 'cat.id')
            ->leftJoin('goods_category as cat2', 'cat.parent_id', '=', 'cat2.id')
            ->leftJoin('shop', 'b.shop_id', '=', 'shop.id')
            ->leftJoin('shop_store', 'b.shop_store_id', '=', 'shop_store.id')
            ->select(
                'b.*','g.goods_name as simple_goods_name','g.goods_name_en as simple_goods_name_en',
                'g.brand_name','g.packing_spec','cat.cat_name','cat.cat_name_en','brand.brand_name_en',
                'g.goods_full_name','g.goods_full_name_en','g.unit_name','g.goods_content','g.goods_content_en','g.cat_id',
                DB::raw('date_format(b.add_time,"%Y-%m-%d") as t'),
                DB::raw('case when b.expiry_time > now() and b.goods_number > 0 then 1 else 0 end as valid'),
                'shop.shop_name_en','shop.company_name_en','shop_store.store_name_en'
            );

        $query = self::setCondition($query, $condition);

        $page = 1;
        $page_size = -1;

        if (isset($pager['pageSize']) || isset($pager['page'])) {
            if (!isset($pager['pageSize']) || intval($pager['pageSize']) <= 0) {
                $page_size = 10;
            } else {
                $page_size = intval($pager['pageSize']);
            }

            if (isset($pager['page']) && intval($pager['page']) > 0) {
                $page = $pager['page'];
            }
        }

        //总条数
        $rs['total'] = $query->count();
        //处理排序
        if (isset($pager['orderType']) && !empty($pager['orderType'])) {
            foreach ($pager['orderType'] as $c => $d) {
                $query = $query->orderBy($c, $d);
            }
        }else{//有效的报价（没过期、没售罄的报价）在前无效的在后，置顶的在前未置顶的在后，时间倒序
            $query = $query->orderBy('valid','desc')->orderBy('t','desc')->orderBy('b.is_roof','desc')->orderBy('b.add_time','desc');
        }
        if ($page_size > 0) {
            $rs['list'] = $query->forPage($page, $page_size)->get()->toArray();
        } else {
            $rs['list'] = $query->get()->toArray();
        }
        $rs['list'] = object_array($rs['list']);
        $rs['page'] = $page;
        $rs['pageSize'] = $page_size;
        $rs['totalPage'] = ceil($rs['total'] / $page_size);
        return $rs;
    }

    //根据条件获取报价列表 分页
    public static function getQuoteInfoBySearchApi($pager,$condition)
    {
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $query = \DB::table($clazz->getTable().' as b')
            ->leftJoin('goods as g', 'b.goods_id', '=', 'g.id')
            ->leftJoin('brand', 'g.brand_id', '=', 'brand.id')
            ->leftJoin('goods_category as cat', 'g.cat_id', '=', 'cat.id')
            ->leftJoin('goods_category as cat2', 'cat.parent_id', '=', 'cat2.id')
            ->leftJoin('shop', 'b.shop_id', '=', 'shop.id')
            ->leftJoin('shop_store', 'b.shop_store_id', '=', 'shop_store.id')
            ->select(
                'b.*','g.goods_name as simple_goods_name','g.goods_name_en as simple_goods_name_en',
                'g.brand_name','g.packing_spec','cat.cat_name','cat.cat_name_en','brand.brand_name_en',
                'g.goods_full_name','g.goods_full_name_en','g.unit_name','g.goods_content','g.goods_content_en','g.cat_id',
                DB::raw('date_format(b.add_time,"%Y-%m-%d") as t'),
                DB::raw('case when b.expiry_time > now() and b.goods_number > 0 then 1 else 0 end as valid'),
                'shop.shop_name_en','shop.company_name_en','shop_store.store_name_en'
            );

        $query = self::setCondition($query, $condition);

        $page = 1;
        $page_size = -1;

        if (isset($pager['pageSize']) || isset($pager['page'])) {
            if (!isset($pager['pageSize']) || intval($pager['pageSize']) <= 0) {
                $page_size = 10;
            } else {
                $page_size = intval($pager['pageSize']);
            }

            if (isset($pager['page']) && intval($pager['page']) > 0) {
                $page = $pager['page'];
            }
        }
        //总条数
        $rs['total'] = $query->count();
        //处理排序
        if (isset($pager['orderType']) && !empty($pager['orderType'])) {
            foreach ($pager['orderType'] as $c => $d) {
                $query = $query->orderBy($c, $d);
            }
        }else{//有效的报价（没过期、没售罄的报价）在前无效的在后，置顶的在前未置顶的在后，时间倒序
            $query = $query->orderBy('valid','desc')->orderBy('t','desc')->orderBy('b.is_roof','desc')->orderBy('b.add_time','desc');
        }
//        dd($query->toSql());
        if ($page_size > 0) {
            $rs['list'] = $query->forPage($page, $page_size)->get()->toArray();
        } else {
            $rs['list'] = $query->get()->toArray();
        }
        $rs['list'] = object_array($rs['list']);
        $rs['page'] = $page;
        $rs['pageSize'] = $page_size;
        $rs['totalPage'] = ceil($rs['total'] / $page_size);
        return $rs;
    }

    //根据条件获取报价列表 不分页
    public static function getQuoteInfoByFields($order,$condition)
    {
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $query = \DB::table($clazz->getTable().' as b')
            ->leftJoin('goods as g', 'b.goods_id', '=', 'g.id')
            ->leftJoin('goods_category as cat', 'g.cat_id', '=', 'cat.id')
            ->leftJoin('shop', 'b.shop_id', '=', 'shop.id')
            ->select('b.*','g.brand_name','g.packing_spec','cat.cat_name','g.goods_full_name','g.goods_full_name_en','g.unit_name','shop.shop_name_en');

        $query = self::setCondition($query, $condition);

        //处理排序
        if (isset($order) && !empty($order)) {
            foreach ($order as $c => $d) {
                $query = $query->orderBy($c, $d);
            }
        }
        $res = $query->get()->toArray();
        return object_array($res);
    }

    //热卖商品，带分页
    public static function getQuoteInfoByFields_se($pager,$condition)
    {
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $query = \DB::table($clazz->getTable().' as b')
            ->leftJoin('goods as g', 'b.goods_id', '=', 'g.id')
            ->leftJoin('goods_category as cat', 'g.cat_id', '=', 'cat.id')
            ->select('b.*','g.brand_name','g.packing_spec','cat.cat_name','g.goods_full_name','g.unit_name');

        $query = self::setCondition($query, $condition);

        $page = 1;
        $page_size = -1;

        if (isset($pager['pageSize']) || isset($pager['page'])) {
            if (!isset($pager['pageSize']) || intval($pager['pageSize']) <= 0) {
                $page_size = 10;
            } else {
                $page_size = intval($pager['pageSize']);
            }
            if (isset($pager['page']) && intval($pager['page']) > 0) {
                $page = $pager['page'];
            }
        }

        //总条数
        $rs['total'] = $query->count();

        //处理排序
        if (isset($pager['orderType']) && !empty($pager['orderType'])) {
            foreach ($pager['orderType'] as $c => $d) {
                $query = $query->orderBy($c, $d);
            }
        }

        if ($page_size > 0) {
            $rs['list'] = $query->forPage($page, $page_size)->get()->toArray();
        } else {
            $rs['list'] = $query->get()->toArray();
        }
        $rs['list'] = object_array($rs['list']);
        $rs['page'] = $page;
        $rs['pageSize'] = $page_size;
        $rs['totalPage'] = ceil($rs['total'] / $page_size);
        return $rs;
    }

    //获取随机报价
    public static function getRandList($take = 5)
    {
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $res = \DB::table($clazz->getTable().' as b')
            ->leftJoin('goods as g', 'b.goods_id', '=', 'g.id')
            ->select('b.*','g.packing_spec','g.goods_full_name_en')
            ->take($take)
            ->get();
        if($res){
            return $res->toArray();
        }
        return [];
    }

    /**
     * productTrend
     * @param $order
     * @param $condition
     * @param int $type 1按日、 2按周、 3按月
     * @return mixed
     */
    public static function productTrend($order,$condition,$type=1){
        if($type == 3){
            $param = 'left(add_time,7) as t';
        }elseif($type == 2){
            $param = "concat(year(add_time),'（第',week(add_time),'周）') as t";
        }else{
            $param = 'left(add_time,10) as t';
        }
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        $query = $query->select(
            '*',
            DB::raw($param),
            DB::raw('max(shop_price) as max_price'),
            DB::raw('min(shop_price) as min_price')
        )->groupBy('t');
        $query = self::setCondition($query, $condition);

        //处理排序
        if (isset($order) && !empty($order)) {
            foreach ($order as $c => $d) {
                $query = $query->orderBy($c, $d);
            }
        }

        $res = $query->get()->toArray();
        return $res;
    }

    public static function getHotDates($condition)
    {
        #SELECT date_format(add_time, '%Y-%m-%d') as t,add_time from shop_goods_quote GROUP BY t limit 2
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $query = \DB::table($clazz->getTable().' as b')
            ->select(
                DB::raw("date_format(b.add_time, '%Y-%m-%d') as t"),'b.add_time'
            );
        $query = self::setCondition($query, $condition);

        $query = $query->groupBy('t')
            ->orderBy('b.add_time','desc')
            ->limit(2);

        $res = $query->get()->toArray();
        return object_array($res);
    }
}

