<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gudang;
class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Gudang::paginate(10);
    }

    public function all()
    {
        //
        return Gudang::all();
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
            'kode' => 'required|unique:gudangs,kode|max:255',
            'nama' => 'required|unique:gudangs,nama|max:255',
        ]);
        $gudang = Gudang::create($request->all());
        if($gudang){
          return response(200);    
        } else {
          return response(500);    
        }
    }
    
    public function search(Request $request){
          
        $gudang = Gudang::where('kode','LIKE',"%$request->q%")
                          ->orWhere('nama','LIKE',"%$request->q%")
                          ->paginate(10);
        if($gudang){
          return response(200);    
        } else {
          return response(500);    
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
        return Gudang::find($id);
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
            'kode' => 'required|unique:gudangs,kode,'.$id.'|max:255',
            'nama' => 'required|unique:gudangs,nama,'.$id.'|max:255',
        ]);
       
        $gudang = Gudang::find($id)->update($request->all());
        if($gudang){
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
        $gudang = Gudang::destroy($id);
        if($gudang){
          return response(200);    
        } else {
          return response(500);
        }
    }
}
