<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransaksiGas;
use App\DetailTransaksiGasMasuk;
use App\DetailTransaksiGasKeluar;
use App\Akun;

class TransaksiGasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return TransaksiGas::paginate(10);
    }

    public function laporanGas(Request $request){

      $kas = $request->kas;
      $dariTanggal = $request->dariTanggal;
      $sampaiTanggal = $request->sampaiTanggal;

      $laporan = TransaksiGas::leftJoin('akuns as akun_yang_masuk',
               'transaksi_kas.akun_masuk','=','akun_yang_masuk.id')
               ->leftJoin('akuns as akun_yang_keluar',
               'transaksi_kas.akun_keluar','=','akun_yang_keluar.id')
               ->select('transaksi_kas.*','akun_yang_masuk.nama as nama_akun_masuk',
               'akun_yang_keluar.nama as nama_akun_keluar')
                ->where('akun_masuk',$kas)
               ->orWhere('akun_keluar',$kas)
               ->where(function($query) use ($dariTanggal,$sampaiTanggal){
                  $query
                   ->whereDate('transaksi_kas.created_at','>=',$dariTanggal)
                   ->whereDate('transaksi_kas.created_at','<=',$sampaiTanggal);
               })
               ->paginate(10);
      return $laporan;

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
    public function storeGasMasuk(Request $request)
    {
        //
        $request->validate([
            'mobil' => 'required',
            'driver' => 'required',
            'status_barang' => 'required',
            'asal_barang' => 'required',
            'tujuan_barang' => 'required',
            'uang_jalan' => 'nullable|numeric',
        ]);
        $noRute = TransaksiGas::noRute();
        $request->request->add(['no_rute' => $noRute]);
        $transaksiGas = TransaksiGas::create($request->all());
        $detailTransaksiGas = $this->storeDetailTransaksiGas($request->produks,
                                                            $request->status_barang,
                                                            $noRute,$transaksiGas->id);

        if($transaksiGas && $detailTransaksiGas){
          return response(200);
        } else {
          return response(500);
        }
    }
    private function storeDetailTransaksiGas($produks,$status_barang,$noRute,$transaksiGasId){

        if($status_barang == 'masuk'){

           foreach($produks as $gas){

              DetailTransaksiGasMasuk::create([
                            'produk_id' => $gas['id'],
                            'nama_produk' => $gas['nama_produk'],
                            'kode_produk' => $gas['kode'],
                            'kosong_p' => $gas['kosong_p'],
                            'kosong_r' => $gas['kosong_r'],
                            'kosong_k' => $gas['kosong_k'],
                            'isi' => $gas['isi'],
                            'no_rute' => $noRute,
                            'transaksi_gas_id' => $transaksiGasId
                            ]);
           }
        } else {

           foreach($produks as $gas){
              DetailTransaksiGasKeluar::create([
                            'produk_id' => $gas['id'],
                            'nama_produk' => $gas['nama'],
                            'kode_produk' => $gas['kode'],
                            'kosong_p' => $gas['kosong_p'],
                            'kosong_r' => $gas['kosong_r'],
                            'kosong_k' => $gas['kosong_k'],
                            'isi' => $gas['isi'],
                            'no_rute' => $noRute,
                            'transaksi_gas_id' => $transaksiGasId
                            ]);
            }
        }
        return true;
    }

    public function storeGasMutasi(Request $request)
    {
        //
        $request->validate([
            'akun_masuk' => 'required|numeric',
            'akun_keluar' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $noTrans = TransaksiGas::noTrans();
        $transaksiGas = TransaksiGas::create(['no_trans' => $noTrans,
                                              'akun_masuk' => $request->akun_masuk,
                                             'akun_keluar' => $request->akun_keluar,
                                             'keluar' => $request->jumlah,
                                             'deskripsi' => $request->deskripsi]);
        if($transaksiGas){
          return response(200);
        } else {
          return response(500);
        }
    }
    public function storeGasKeluar(Request $request)
    {
        //
        $request->validate([
            'akun_masuk' => 'required|numeric',
            'akun_keluar' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $noTrans = TransaksiGas::noTrans();
        $transaksiGas = TransaksiGas::create(['no_trans' => $noTrans,
                                             'akun_masuk' => $request->akun_masuk,
                                             'akun_keluar' => $request->akun_keluar,
                                             'keluar' => $request->jumlah,
                                             'deskripsi' => $request->deskripsi]);
        if($transaksiGas){
          return response(200);
        } else {
          return response(500);
        }
    }

    public function search(Request $request){

        $transaksiGas = TransaksiGas::where('id',$request->q)
                          ->orWhere('deskripsi','LIKE',"%$request->q%")
                          ->paginate(10);
        return $transaksiGas;
    }

    public function posisiGas(){

       $akunGas =  Akun::where('jenis','kas')->get();
       $posisiGas = [];
       foreach($akunGas as $akun){

          $kasMasuk = TransaksiGas::where('akun_masuk',$akun->id)->sum('masuk');
          $kasKeluar = TransaksiGas::where('akun_keluar',$akun->id)->sum('keluar');
          $kasMutasi = TransaksiGas::where('akun_masuk',$akun->id)->sum('keluar');
          $jumlahGas = $kasMasuk - $kasKeluar + $kasMutasi;
          array_push($posisiGas,['id' => $akun->id,'nama'=>  $akun->nama,'jumlah' => $jumlahGas]);
       }

       return $posisiGas;

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
        $transaksiGas = TransaksiGas::find($id);
        if($transaksiGas->status_barang == 'masuk'){
           $produks = DetailTransaksiGasMasuk::where('transaksi_gas_id',$id)->get();
        } else {
           $produks = DetailTransaksiGasKeluar::where('transaksi_gas_id',$id)->get();

        }
        $transaksiGas = TransaksiGas::find($id);
        $transaksiGas->produks = $produks;
        return $transaksiGas ;
    }

    public function editGas($id){

        $transaksiGas = TransaksiGas::find($id);
        if($transaksiGas->status_barang == 'masuk'){
           return DetailTransaksiGasMasuk::where('transaksi_gas_id',$id)->get();
        } else {
           return DetailTransaksiGasKeluar::where('transaksi_gas_id',$id)->get();

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateGasMasuk(Request $request, $id){

        $request->validate([
            'mobil' => 'required',
            'driver' => 'required',
            'status_barang' => 'required',
            'asal_barang' => 'required',
            'tujuan_barang' => 'required',
            'uang_jalan' => 'nullable|numeric',
        ]);
        $transaksiGas = TransaksiGas::find($id)->update($request->all());
        $detailTransaksiGas = $this->updateDetailTransaksiGas(
                                        $request->produks,
                                        $request->status_barang,
                                        $request->no_rute,
                                        $id
                                        );
        if($transaksiGas){
          return response(200);
        } else {
          return response()->status(500);
        }
    }
    private function updateDetailTransaksiGas($produks,$status_barang,$noRute,$transaksiGasId){


        if($status_barang == 'masuk'){
           DetailTransaksiGasMasuk::where('transaksi_gas_id',$transaksiGasId)->delete();
           foreach($produks as $gas){

              DetailTransaksiGasMasuk::create([
                            'produk_id' => $gas['produk_id'],
                            'nama_produk' => $gas['nama_produk'],
                            'kode_produk' => $gas['kode_produk'],
                            'kosong_p' => $gas['kosong_p'],
                            'kosong_r' => $gas['kosong_r'],
                            'kosong_k' => $gas['kosong_k'],
                            'isi' => $gas['isi'],
                            'no_rute' => $noRute,
                            'transaksi_gas_id' => $transaksiGasId
                            ]);
           }
        } else {

           DetailTransaksiGasKeluar::where('transaksi_gas_id',$transaksiGasId)->delete();
           foreach($produks as $gas){
              DetailTransaksiGasKeluar::create([
                            'produk_id' => $gas['id'],
                            'nama_produk' => $gas['nama'],
                            'kode_produk' => $gas['kode'],
                            'kosong_p' => $gas['kosong_p'],
                            'kosong_r' => $gas['kosong_r'],
                            'kosong_k' => $gas['kosong_k'],
                            'isi' => $gas['isi'],
                            'no_rute' => $noRute,
                            'transaksi_gas_id' => $transaksiGasId
                            ]);
            }
        }
        return true;
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
        $transaksiGas = TransaksiGas::destroy($id);
        if($transaksiGas){
          return response(200);
        } else {
          return response(500);
        }
    }
}
