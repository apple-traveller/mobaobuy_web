<?php
/**
 * Created by PhpStorm.
 * User: kery
 * Date: 2018/9/11
 * Time: 9:31
 */
interface GSXXInterface{
    public static function getConfigParams();
    public function setConfig($config);
    public function getBaseInfo($company_name);
}
