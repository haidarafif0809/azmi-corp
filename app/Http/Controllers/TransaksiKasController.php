<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransaksiKas;
use App\Akun;

class TransaksiKasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return TransaksiKas::leftJoin('akuns as akun_yang_masuk',
               'transaksi_kas.akun_masuk','=','akun_yang_masuk.id')
               ->leftJoin('akuns as akun_yang_keluar',
               'transaksi_kas.akun_keluar','=','akun_yang_keluar.id')
               ->select('transaksi_kas.*','akun_yang_masuk.nama as nama_akun_masuk',
               'akun_yang_keluar.nama as nama_akun_keluar')
               ->paginate(10);
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
        $transaksiKas = TransaksiKas::create($request->all());
        if($transaksiKas){
          return response(200);    
        } else {
          return response(500);    
        }
    }
    public function storeKasMasuk(Request $request)
    {
        //
        $request->validate([
            'akun_masuk' => 'required|numeric',
            'akun_keluar' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $noTrans = TransaksiKas::noTrans();
        $transaksiKas = TransaksiKas::create(['no_trans' => $noTrans,
                                             'akun_masuk' => $request->akun_masuk,
                                             'akun_keluar' => $request->akun_keluar,
                                             'masuk' => $request->jumlah,
                                             'deskripsi' => $request->deskripsi]);
        if($transaksiKas){
          return response(200);    
        } else {
          return response(500);    
        }
    }
    public function storeKasMutasi(Request $request)
    {
        //
        $request->validate([
            'akun_masuk' => 'required|numeric',
            'akun_keluar' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $transaksiKas = TransaksiKas::create(['no_trans' => $noTrans,
                                              'akun_masuk' => $request->akun_masuk,
                                             'akun_keluar' => $request->akun_keluar,
                                             'masuk' => $request->jumlah,
                                             'deskripsi' => $request->deskripsi]);
        if($transaksiKas){
          return response(200);    
        } else {
          return response(500);    
        }
    }
    public function storeKasKeluar(Request $request)
    {
        //
        $request->validate([
            'akun_masuk' => 'required|numeric',
            'akun_keluar' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $transaksiKas = TransaksiKas::create(['akun_masuk' => $request->akun_masuk,
                                             'akun_keluar' => $request->akun_keluar,
                                             'keluar' => $request->jumlah,
                                             'deskripsi' => $request->deskripsi]);
        if($transaksiKas){
          return response(200);    
        } else {
          return response(500);    
        }
    }
    
    public function search(Request $request){
          
        $transaksiKas = TransaksiKas::where('id',$request->q)
                          ->orWhere('deskripsi','LIKE',"%$request->q%")
                          ->paginate(10);
        return $transaksiKas;
    }

    public function posisiKas(){

       $akunKas =  Akun::where('jenis','kas')->get();
       $posisiKas = [];
       foreach($akunKas as $akun){

          $kasMasuk = TransaksiKas::where('akun_masuk',$akun->id)->sum('masuk');
          $kasKeluar = TransaksiKas::where('akun_keluar',$akun->id)->sum('keluar');
          $jumlahKas = $kasMasuk - $kasKeluar;
          array_push($posisiKas,['id' => $akun->id,'nama'=>  $akun->nama,'jumlah' => $jumlahKas]);
       } 

       return $posisiKas;

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
        return TransaksiKas::find($id);
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
       
        $transaksiKas = TransaksiKas::find($id)->update($request->all());
        if($transaksiKas){
          return response(200);    
        } else {
          return response(500);    
        }

    }
    public function updateKasMasuk(Request $request, $id){
        
        $request->validate([
            'akun_masuk' => 'required|numeric',
            'akun_keluar' => 'required|numeric',
            'masuk' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $transaksiKas = TransaksiKas::find($id)->update($request->all());
        if($transaksiKas){
          return response(200);    
        } else {
          return response()->status(500);    
        }
    }
    public function updateKasKeluar(Request $request, $id){
        
        $request->validate([
            'akun_masuk' => 'required|numeric',
            'akun_keluar' => 'required|numeric',
            'keluar' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $transaksiKas = TransaksiKas::find($id)->update($request->all());
        if($transaksiKas){
          return response(200);    
        } else {
          return response()->status(500);    
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
        $transaksiKas = TransaksiKas::destroy($id);
        if($transaksiKas){
          return response(200);    
        } else {
          return response(500);
        }
    }
}
