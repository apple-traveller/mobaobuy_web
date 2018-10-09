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
