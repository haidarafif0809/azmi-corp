<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mobil;
class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Mobil::paginate(10);
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

        $request->validate([
            'kode' => 'required|unique:mobils,kode|max:255',
            'plat' => 'required|unique:mobils,plat|max:255',
        ]);
        $createMobil = Mobil::create(['kode' => $request->kode,'plat' => $request->plat]);
        if($createMobil){
          return response(200);
        } else {
          return response(500);
        }
    }

    public function search(Request $request){
     return Mobil::where('kode','LIKE',"%$request->q%")
               ->orWhere('plat','LIKE',"%$request->q%")->paginate(10);
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
        return Mobil::find($id);
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
        //

        $request->validate([
            'kode' => 'required|unique:mobils,kode,'.$id.'|max:255',
            'plat' => 'required|unique:mobils,plat,'.$id.'|max:255',
        ]);
        $updateMobil = Mobil::find($id)
                       ->update(['kode' => $request->kode,'plat' => $request->plat]);
        if($updateMobil){
          return response(200);
        } else {
          return response(500);
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
        $deleteMobil = Mobil::destroy($id);
        if($deleteMobil){
          return response(200);    
        } else {
          return response(500);
        }
    }
}
