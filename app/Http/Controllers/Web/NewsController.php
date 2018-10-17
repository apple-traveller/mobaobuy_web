<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-17
 * Time: 10:53
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        return $this->display('web.news.index');
    }
}
