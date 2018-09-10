<?php
namespace App\Http\ViewComposers;
use Illuminate\View\View;
use App\Http\Controllers\Web\SysConfigController;

class commonComposer
{
    public $cacheInfo;
    public function __construct(SysConfigController $cacheInfo)
    {
        $this->cacheInfo = $cacheInfo;
    }

    public function compose(View $view){
        $sysCacheInfo = $this->cacheInfo->sysCacheSet();
        $view->with('sysCacheInfo',$sysCacheInfo);
    }
}

?>