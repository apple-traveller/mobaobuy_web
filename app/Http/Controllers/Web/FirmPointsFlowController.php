<?php

namespace App\Http\Controllers\Web;
use App\Services\FirmPointsFlowService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class FirmPointsFlowController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function create(Request $request){
        $rule = [
            'change_type'=>'required|numeric',
            'points'=>'required|numeric',
            'change_info'=>'required'
        ];
        $data = $this->validate($request,$rule);
        $data['firm_id'] = session('_web_info')['id'];
        DB::beginTransaction();
        try{
            FirmPointsFlowService::createPoints($data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            return $this->error($e->getMessage());
        }
    }
}
