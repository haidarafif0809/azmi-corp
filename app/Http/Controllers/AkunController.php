<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Akun;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Akun::paginate(10);
    }

    public function all(Request $request)
    {
        //
        if(isset($request->kas)){
            
          return Akun::where('jenis','kas')->get();
        } else {
              
          return Akun::where('jenis','!=','kas')->get();
        }

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
            'kode' => 'required|unique:akuns,kode|max:255',
            'nama' => 'required|unique:akuns,nama|max:255',
            'jenis' => 'required',
        ]);
        $akun = Akun::create($request->all());
        if($akun){
          return response(200);    
        } else {
          return response(500);    
        }
    }
    
    public function search(Request $request){
          
        $akun = Akun::where('kode','LIKE',"%$request->q%")
                          ->orWhere('nama','LIKE',"%$request->q%")
                          ->paginate(10);
        return $akun;
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
        return Akun::find($id);
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
            'kode' => 'required|unique:akuns,kode,'.$id.'|max:255',
            'nama' => 'required|unique:akuns,nama,'.$id.'|max:255',
            'jenis' => 'required',
        ]);
       
        $akun = Akun::find($id)->update($request->all());
        if($akun){
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
        $akun = Akun::destroy($id);
        if($akun){
          return response(200);    
        } else {
          return response(500);
        }
    }
}
