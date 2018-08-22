<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
class ExcelController extends Controller
{
    //导出
    public  function export($cellData,$filename)
    {
        /*$cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];*/

        Excel::create($filename,function ($excel) use ($cellData){
            $excel->sheet("SHEET", function ($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');

    }


    //导入
    public  function import()
    {

    }
}
