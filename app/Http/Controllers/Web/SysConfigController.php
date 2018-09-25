<?php

namespace App\Http\Controllers\Web;

use App\Services\SysConfigService;
use Illuminate\Http\Request;
use App\Services\Web\UserLoginService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class SysConfigController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    public function __construct(){
        session()->put('theme','default');
    }


}
