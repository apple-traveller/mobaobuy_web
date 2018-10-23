<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

trait CommonRepo
{
    private static function getBaseModel()
    {
        $x_clazz_name = 'X_'.preg_replace('/(?<=[a-z])([A-Z])/', '_$1', str_replace('Repo', '', basename(str_replace('\\', '/', __CLASS__))));
        return "App\\Models\\" . $x_clazz_name;
    }

    public static function getListBySearch($pager, $condition)
    {
        $clazz = self::getBaseModel();
        $query = $clazz::query();
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

    public static function getList($order = [], $condition=[], $columns = ['*'])
    {
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        $query = self::setCondition($query, $condition);

        //处理排序
        if (!empty($order)) {
            foreach ($order as $c => $d) {
                $query = $query->orderBy($c, $d);
            }
        }

        return $query->get($columns)->toArray();
    }

    private static function setCondition($query, $condition){
        $opt = 'AND';
        if(isset($condition['opt']) && in_array($condition['opt'], array('AND','OR'))){
            $opt = $condition['opt'];
            unset($condition['opt']);
        }

        if(isset($condition['list'])){
            $where = $condition['list'];
        }else{
            $where = $condition;
        }
        $query = $query->Where(function($q) use($opt, $where){
            foreach ($where as $key => $value){
                if(is_array($value)){
                    if($opt == 'OR'){
                        $q = $q->orWhere(function($s_q) use($value){
                            $s_q = self::setCondition($s_q, $value);
                        });
                    }else{
                        $q = $q->Where(function($s_q) use($value){
                            $s_q = self::setCondition($s_q, $value);
                        });
                    }
                }else{
                    $value = trim($value);
                    if(strpos($value, '%') === 0 || substr($value, -1) == '%'){
                        if($opt == 'OR'){
                            $q = $q->orWhere($key, 'like', $value);
                        }else{
                            $q = $q->Where($key, 'like', $value);
                        }
                    }elseif(strpos($value, '|') !== false){
                        if($opt == 'OR'){
                            $q = $q->orWhereIn($key, explode('|', $value));
                        }else{
                            $q = $q->WhereIn($key, explode('|', $value));
                        }
                    }elseif(strpos($value, '!') === 0 ){
                        if($opt == 'OR'){
                            $q = $q->orWhere($key, '<>', substr($value, 1));
                        }else{
                            $q = $q->Where($key, '<>', substr($value, 1));
                        }
                    }elseif(strpos($key, '|') !== false){
                        $arr = explode('|', $key);
                        if(sizeof($arr) == 2 && in_array($arr[1], ['>','>=','<','<=','!=','<>'])){
                            if($opt == 'OR'){
                                $q = $q->orWhere($arr[0], $arr[1], $value);
                            }else{
                                $q = $q->Where($arr[0], $arr[1], $value);
                            }
                        }else{
                            throw new \Exception('参数名称格式不正确：'.$key);
                        }
                    }else{
                        if($opt == 'OR'){
                            $q = $q->orWhere($key, $value);
                        }else{
                            $q = $q->Where($key, $value);
                        }
                    }
                }
            }
        });
        return $query;
    }

    public static function getTotalCount($where = []){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        if(!empty($where) && is_array($where)){
            $query = self::setCondition($query, $where);
        }
        $value = $query->count();
        return $value;
    }

    public static function getMax($field, $where)
    {
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        if(!empty($where) && is_array($where)){
            foreach ($where as $name => $value){
                $query = $query->where($name, $value);
            }
        }
        $value = $query->max($field);
        return $value;
    }

    public static function create($data)
    {
        $clazz = self::getBaseModel();
        $info = new $clazz();
        foreach ($data as $k => $v) {
            $info->$k = $v;
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
                if($info->getKeyName() !== $k){
                    $info->$k = $v;
                }
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

    public static function delete($id)
    {
        $model = self::getBaseModel();
        $info = $model::destroy($id);
        if ($info) {
            return true;
        }
        return false;
    }

    public static function deleteByFields($where)
    {
        $model = self::getBaseModel();
        $query = $model::query();
        foreach ($where as $name => $value){
            $query = $query->where($name, $value);
        }
        $deletedRows = $query->delete();
        return $deletedRows;
    }
}
