<?php

namespace App\Http\Controllers\Web;

use App\Services\Web\GoodsCategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $goodsCategoryInfo = GoodsCategoryService::GoodsCategoryInfo();
        return $this->display('web.index',compact('goodsCategoryInfo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rule = [
            'cat_name'=>'required|unique:goods_category',
            'parent_id'=>'required|numeric',
            'is_nav_show'=>'required|numeric',
            'is_show'=>'required|numeric',
            'category_links'=>'required',
            'cat_alias_name'=>'nulleric'
        ];
        $data = $this->validate($request,$rule);
        try{
            GoodsCategoryService::categoryCreate($data);
        }catch (\Exception $e){
           return $this->error($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $id = $request->input('id');
        $rule = [
            'cat_name'=>'required|unique:goods_category',
            'parent_id'=>'required|numeric',
            'is_nav_show'=>'numeric',
            'is_show'=>'required|numeric',
            'category_links'=>'nullable',
            'cat_alias_name'=>'nullable'
        ];
        $data = $this->validate($request,$rule);
        try{
            GoodsCategoryService::categoryUpdate($id,$data);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        GoodsCategoryService::delete($id);
    }
}
