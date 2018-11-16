<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

use function App\Helpers\object_array;
use Illuminate\Support\Facades\DB;

class OrderInfoRepo
{
    use CommonRepo;
    public static function orderList($userId){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->where('user_id',$userId)->paginate(10);
    }

    //统计当月每天的订单量
    public static function getEveryMonthOrderCount($start_time,$end_time){

        $clazz = self::getBaseModel();
        $query = $clazz::query();
        $res = $query->select(
            DB::raw('day(add_time) as d'),DB::raw('count(*) as order_count')
        )->where('add_time','>',$start_time)->where('add_time','<',$end_time)->groupBy('d')->get();
        if($res){
            return $res->toArray();
        }
        return [];
    }

    /**
     * 当年每月的订单量
     * @param $start_time
     * @param $end_time
     * @param string $condition
     * @return array
     */
    public static function getCurrYearEveryMonth($start_time,$end_time,$condition='1=1')
    {
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        $res = $query->select(
            DB::raw('month(add_time) as m'),DB::raw('count(1) as order_count')
            )->where('add_time','>',$start_time)
            ->where('add_time','<',$end_time)
            ->where($condition)
            ->groupBy('m')
            ->get();
        if($res){
            return $res->toArray();
        }
        return [];
    }
}
