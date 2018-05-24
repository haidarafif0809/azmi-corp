<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Perusahaan::paginate(10);

    }
    public function all()
    {
        //
        return Perusahaan::all();

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
            'no_telp' => 'required|unique:perusahaans,no_telp|max:255',
            'nama' => 'required|unique:perusahaans,nama|max:255',
            'alamat' => 'required|unique:perusahaans,alamat|max:255',
        ]);
        $perusahaan = Perusahaan::create($request->all());
        if($perusahaan){
          return response(200);
        } else {
          return response(500);
        }
    }

    public function search(Request $request){
      return Perusahaan::where('no_telp','LIKE',"%$request->q%")
            ->orWhere('nama','LIKE',"%$request->q%")
            ->orWhere('no_telp','LIKE',"%$request->q%")
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
        return Perusahaan::find($id);
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
      $request->validate([
          'no_telp' => 'required|max:255',
          'nama' => 'required|max:255',
          'alamat' => 'required|max:255'
      ]);
      $updatePerusahaan = Perusahaan::find($id)->update($request->all());
      if($updatePerusahaan){
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
        $deletePerusahaan = Perusahaan::destroy($id);
        if($deletePerusahaan){
          return response(200);
        } else {
          return response(500);
        }
    }
}
