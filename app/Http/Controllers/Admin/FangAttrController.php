<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fangattr;
use Illuminate\Http\Request;

class FangAttrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //实例化
        $model = new Fangattr();
        $data = $model->getList();

        return view('admin.fangattr.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取顶级属性
        $data = Fangattr::where('pid',0)->get();
        return view('admin.fangattr.create',compact('data'));
    }
    public function upfile(Request $request)
    {
        //封面图片
        $pic = config('up.pic');
        if($request->hasFile('file')){
            //shangchuan
            $p = $request->file('file')->store('','fangattr');
            $pic = '/uploads/fangattr/'.$p;
        }
        return ['status'=>0,'url'=>$pic];
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fangattr  $fangattr
     * @return \Illuminate\Http\Response
     */
    public function show(Fangattr $fangattr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fangattr  $fangattr
     * @return \Illuminate\Http\Response
     */
    public function edit(Fangattr $fangattr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fangattr  $fangattr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fangattr $fangattr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fangattr  $fangattr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fangattr $fangattr)
    {
        //
    }
}
