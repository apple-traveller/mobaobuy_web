<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-17
 * Time: 13:52
 */
namespace App\Services;

use App\Repositories\GsxxCompanyRepo;
use App\Repositories\GsxxSendLogRepo;
use App\Repositories\GsxxSupplierRepo;

class GsxxService
{
    use CommonService;

    public static function GsSearch($key_words)
    {
        $supplierInfo = GsxxSupplierRepo::getInfoByFields(['is_checked'=>1]);
        $code = $supplierInfo['supplier_code'];
        $GsxxDir = dirname(__DIR__) . "/Plugins/GSXX/{$code}/GsxxObj.php";

        if (file_exists($GsxxDir)){
            require_once $GsxxDir;
            $Gsxx = new \GsxxObj();
        } else {
            self::throwBizError('配置文件不存在');
        }

        $config = json_decode($supplierInfo['supplier_config'],true);

        // 先查数据库
        $res = GsxxCompanyRepo::getInfoByFields(["Name" =>$key_words]);
        if (!empty($res)){
            return $res;
        } else {
            $Gsxx->setConfig($config);
            $re = $Gsxx->getBaseInfo($key_words);
            if ($re){
                $record_log = [
                    'supplier_id' => $supplierInfo['id'],
                    'params' => $key_words,
                    'supplier_rs' => $re,
                    'sent_time' => date('Y-m-d H:i:s')
                ];
                // 插入查询记录
                GsxxSendLogRepo::create($record_log);

                $rs = json_decode($re);
                if ($rs->Status == '200'){
                    $data = [
                        'KeyNo' => $rs->Result->KeyNo,
                        'Name' => $rs->Result->Name,
                        'No' => $rs->Result->No,
                        'BelongOrg' => $rs->Result->BelongOrg,
                        'OperName' => $rs->Result->OperName,
                        'StartDate' => $rs->Result->StartDate,
                        'EndDate' => $rs->Result->EndDate,
                        'Status' => $rs->Result->Status,
                        'Province' => $rs->Result->Province,
                        'UpdatedDate' => $rs->Result->UpdatedDate,
                        'CreditCode' => $rs->Result->CreditCode,
                        'RegistCapi' => $rs->Result->RegistCapi,
                        'EconKind' => $rs->Result->EconKind,
                        'Address' => $rs->Result->Address,
                        'Scope' => $rs->Result->Scope,
                        'TermStart' => $rs->Result->TermStart,
                        'TeamEnd' => $rs->Result->TeamEnd,
                        'CheckDate' => $rs->Result->CheckDate,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    // 将查到的工商信息插入数据库
                    $res = GsxxCompanyRepo::create($data);
                    return $res;
                } else {
                    return false;
                }
            } else {
                return '';
            }
        }
    }
}
