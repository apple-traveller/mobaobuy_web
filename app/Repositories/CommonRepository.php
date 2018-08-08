<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

trait CommonRepository
{
    private static function getBaseModel()
    {
        $model_name = str_replace('Repository', 'Model', basename(str_replace('\\', '/', __CLASS__)));
        return "App\\Models\\" . $model_name;
    }

    private static function searchQuery($pager, $query)
    {
        $page = 1;
        $page_size = -1;

        if (isset($pager['pageSize']) || isset($pager['page'])) {
            if (!isset($pager['pageSize']) || intval($pager['pageSize']) <= 0) {
                $page_size = 15;
            } else {
                $page_size = intval($pager['pageSize']);
            }

            if (isset($pager['page']) && intval($pager['page']) > 0) {
                $page = $pager['page'];
            }
        }
        //总条数
        $rs['total'] = $query->toBase()->getCountForPagination();
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

        $rs['page'] = $page;
        $rs['pageSize'] = $page_size;
        $rs['totalPage'] = ceil($rs['total'] / $page_size);
        return $rs;
    }

    public static function create($data)
    {
        $clazz = self::getBaseModel();
        $info = new $clazz();
        foreach ($data as $k => $v) {
            $info->$k ='"'.$v.'"';
        }
        $info->save();
        return $info->toArray();
    }

    public static function modify($id, $data)
    {
        $model = self::getBaseModel();
        $info = $model::find($id); //模型实例
        if ($info) {
            foreach ($data as $k => $v) {
                $info->$k = $v;
            }
            $info->save();
            return $info->toArray();
        }
        return false;
    }

    public static function getInfo($id)
    {
        $model = self::getBaseModel();
        $info = $model::find($id);
        if ($info) {
            return $info->toArray();
        }
        return [];
    }

    public static function getInfoByFields($where)
    {
        if(empty($where) || !is_array($where)){
            return [];
        }
        $model = self::getBaseModel();
        $query = $model::query();
        foreach ($where as $name => $value){
            $query = $query->where($name, $value);
        }

        $info = $query->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }
}