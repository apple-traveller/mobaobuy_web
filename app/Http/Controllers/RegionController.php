<?php

namespace App\Http\Controllers;

use App\Services\RegionService;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function regionLevelList(Request $request)
    {
        $parent_id = $request->input('parent',0);
        $level = $request->input('level',0);
        $region_list = RegionService::getLevelRegion($level, $parent_id);

        return $this->success('success', '', $region_list);
    }
}
