<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Services\Web\IndexService;
use App\Http\Controllers\Controller;


class IndexController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
}
