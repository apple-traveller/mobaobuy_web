<?php
namespace App\Http\Controllers\Web;

use App\Services\FirmUserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class FirmUserController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    public function search($username){
        $userInfo = FirmUserService::search($username);
        return $this->display('web',compact('userInfo'));
    }
    public function createFirmUser(Request $request){
        $rule = [
            'firm_id'=>'required|numeric',
            'user_id'=>'required|numeric',
            'real_name'=>'required|max:30',
            'can_po'=>'required|numeric',
            'can_pay'=>'required|numeric ',
            'can_confirm'=>'required|numeric',
            'can_stock_in'=>'required|numeric',
            'can_stock_out'=>'required|numeric'
        ];
        $data = $this->validate($request,$rule);
        try{
            FirmUserService::create($data);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function updateFirmUser(Request $request){
        $rule = [
            'firm_id'=>'required|numeric',
            'user_id'=>'required|numeric',
            'real_name'=>'required|max:30',
            'can_po'=>'required|numeric',
            'can_pay'=>'required|numeric ',
            'can_confirm'=>'required|numeric',
            'can_stock_in'=>'required|numeric',
            'can_stock_out'=>'required|numeric'
        ];
        $data = $this->validate($request,$rule);
        try{
            FirmUserService::update($data);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function destroy($id){

    }
}
