<?php
namespace App\Http\Controllers\Web;

use App\Services\FirmUserService;
use App\Services\ShopGoodsQuoteService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopGoodsQuoteController extends Controller
{
    //获取报价列表
    public function goodsQuoteList(Request $request){
        $shopId = $request->input('shop_id',1);
        try{
            $goodsQuote = ShopGoodsQuoteService::goodsQuoteList();
            return $this->display('web.goods.goodsQuote',compact('goodsQuote'));
        }
        catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
