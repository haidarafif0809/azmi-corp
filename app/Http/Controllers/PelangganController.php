<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Pelanggan::paginate(10);
    }

    public function all()
    {
        //
        return Pelanggan::all();
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
            'kode' => 'required|unique:pelanggans,kode|max:255',
            'nama' => 'required|unique:pelanggans,nama|max:255',
            'kontak' => 'required|unique:pelanggans,kontak|max:255',
        ]);
        $pelanggan = Pelanggan::create($request->all());
        if($pelanggan){
          return response(200);
        } else {
          return response(500);    
        }
    }
    
    public function search(Request $request){
    
    $pelanggan = Pelanggan::where('kode','LIKE',"%$request->q%")
                               ->orWhere('nama','LIKE',"%$request->q%")
                               ->orWhere('kontak','LIKE',"%$request->q%")
                               ->paginate(10);
       return $pelanggan; 
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
        return Pelanggan::find($id);
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
            'kode' => 'required|unique:pelanggans,kode,'.$id.'|max:255',
            'nama' => 'required|unique:pelanggans,nama,'.$id.'|max:255',
            'kontak' => 'required|unique:pelanggans,kontak,'.$id.'|max:255',
        ]);
        $pelanggan = Pelanggan::find($id)->update($request->all());
        if($pelanggan){
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
        $pelanggan = Pelanggan::destroy($id);
        if($pelanggan){
          return response(200);    
        } else {
          return response(500);    
        }
    }
}
