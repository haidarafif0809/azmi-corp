<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\DetailTransaksiGasMasuk;
use App\DetailTransaksiGasKeluar;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $produks = Produk::paginate(10);
        foreach($produks as $produk){
          $jumlahKosongP = $this->jumlahGas($produk->id,'kosong_p');
          $jumlahKosongR = $this->jumlahGas($produk->id,'kosong_r');
          $jumlahKosongK = $this->jumlahGas($produk->id,'kosong_k');
          $jumlahIsi = $this->jumlahGas($produk->id,'isi');
          $produk->kosong_p = $jumlahKosongP;
          $produk->kosong_r = $jumlahKosongR;
          $produk->kosong_k = $jumlahKosongK;
          $produk->isi = $jumlahIsi;
        }

        return $produks;
    }


    private function jumlahGas($produkId,$jenis){

          $masuk = DetailTransaksiGasMasuk::where('produk_id',$produkId)->sum($jenis);
          $keluar = DetailTransaksiGasKeluar::where('produk_id',$produkId)->sum($jenis);
          $jumlah =  $masuk - $keluar;
          return $jumlah;
    }
    public function all()
    {
        //
        return Produk::all();
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
            'kode' => 'required|unique:produks,kode|max:255',
            'nama' => 'required|unique:produks,nama|max:255',
            'warna' => 'required|unique:produks,warna|max:255',
        ]);
        $produk = Produk::create($request->all());
        if($produk){
          return response(200);
        } else {
          return response(500);
        }
    }

    public function search(Request $request){

        $produk = Produk::where('kode','LIKE',"%$request->q%")
                          ->orWhere('nama','LIKE',"%$request->q%")
                          ->paginate(10);
        return $produk;
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
        return Produk::find($id);
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
            'kode' => 'required|unique:produks,kode,'.$id.'|max:255',
            'nama' => 'required|unique:produks,nama,'.$id.'|max:255',
            'warna' => 'required|unique:produks,warna,'.$id.'|max:255',
        ]);

        $produk = Produk::find($id)->update($request->all());
        if($produk){
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
        $produk = Produk::destroy($id);
        if($produk){
          return response(200);
        } else {
          return response(500);
        }
    }
}
