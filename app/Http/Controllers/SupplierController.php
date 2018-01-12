<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Supplier::paginate(10);
        
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
            'kode' => 'required|unique:suppliers,kode|max:255',
            'nama' => 'required|unique:suppliers,nama|max:255',
            'kontak' => 'required|unique:suppliers,kontak|max:255',
        ]);
        $supplier = Supplier::create($request->all());
        if($supplier){
          return response(200);
        } else {
          return response(500);
        }
    }

    public function search(Request $request){
      return Supplier::where('kode','LIKE',"%$request->q%")
            ->orWhere('nama','LIKE',"%$request->q%")
            ->orWhere('kode','LIKE',"%$request->q%")    
            ->paginate(10);
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
        return Supplier::find($id);
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
            'kode' => 'required|unique:suppliers,kode,'.$id.'|max:255',
            'nama' => 'required|unique:suppliers,nama,'.$id.'|max:255',
            'kontak' => 'required|unique:suppliers,kontak,'.$id.'|max:255']);
        $updateSupplier = Supplier::find($id)->update($request->all());
        if($updateSupplier){
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
        $deleteSupplier = Supplier::destroy($id);
        if($deleteSupplier){
          return response(200);    
        } else {
          return response(500);    
        }
    }
}
