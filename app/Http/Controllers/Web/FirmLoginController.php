<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Services\FirmLoginService;
use App\Http\Controllers\Controller;


class FirmLoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    public function __construct()
    {
        session()->put('theme','default');
    }


}
