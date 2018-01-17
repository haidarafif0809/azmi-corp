<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kas;

class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Kas::paginate(10);
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
            'kode' => 'required|unique:kas,kode|max:255',
            'nama' => 'required|unique:kas,nama|max:255',
        ]);
        $kas = Kas::create($request->all());
        if($kas){
          return response(200);    
        } else {
          return response(500);    
        }
    }
    
    public function search(Request $request){
          
        $kas = Kas::where('kode','LIKE',"%$request->q%")
                          ->orWhere('nama','LIKE',"%$request->q%")
                          ->paginate(10);
        if($kas){
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
        return Kas::find($id);
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
            'kode' => 'required|unique:kas,kode,'.$id.'|max:255',
            'nama' => 'required|unique:kas,nama,'.$id.'|max:255',
        ]);
       
        $kas = Kas::find($id)->update($request->all());
        if($kas){
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
        $kas = Kas::destroy($id);
        if($kas){
          return response(200);    
        } else {
          return response(500);
        }
    }
}
