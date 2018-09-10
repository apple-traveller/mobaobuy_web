<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

<<<<<<< HEAD:app/Services/BaseService.php
trait BaseService
=======
trait CommonService
>>>>>>> 039764dbb692d11bb288c6921e8081269efa3aaf:app/Services/CommonService.php
{
    protected static function throwBizError($msg, $code = 0){
        throw new \Exception($msg, $code);
    }

    protected static function beginTransaction(){
        DB::beginTransaction();
    }

    protected static function rollBack(){
        DB::rollBack();
    }

    protected static function commit(){
        DB::commit();
    }

    protected static function createDB($db_name){
        DB::statement("create database $db_name");
    }

    protected static function changeDB($db_name){
        DB::unprepared("use $db_name");
    }

    protected static function statement($sql){
        DB::unprepared($sql);
    }

    protected static function statementFile($sql_files){
        if (!is_array($sql_files))
        {
            $sql_files = [$sql_files];
        }

        foreach ($sql_files AS $file_path)
        {
            if (!file_exists($file_path))
            {
                self::throwError('数据库文件'.$file_path.'不存在！');
            }

            /* 读取SQL文件 */
            $sql = implode('', file($file_path));

            /* 删除SQL注释，由于执行的是replace操作，所以不需要进行检测。下同。 */
            //删除SQL行注释，行注释不匹配换行符
            $sql = preg_replace('/^\s*(?:--|#).*/m', '', $sql);
            //删除SQL块注释，匹配换行符，且为非贪婪匹配
            $sql = preg_replace('/^\s*\/\*.*?\*\//ms', '', $sql);

            /* 删除SQL串首尾的空白符 */
            $sql = trim($sql);

            if (!$sql)
            {
                continue;
            }

            /* 解析查询项 */
            $sql = str_replace("\r", '', $sql);
            $query_items = explode(";\n", $sql);

            /* 如果解析失败，则跳过 */
            if (!$query_items)
            {
                continue;
            }

            foreach ($query_items AS $key=>$query_item)
            {
                /* 如果查询项为空，则跳过 */
                if (!$query_item)
                {
                    continue;
                }
                \Log::info($query_item);

                self::statement($query_item);
            }
        }
    }
}