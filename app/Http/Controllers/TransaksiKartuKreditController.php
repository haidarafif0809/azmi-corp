<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransaksiKartuKredit;
use App\Akun;

class TransaksiKartuKreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return TransaksiKartuKredit::with(['kartu_kredit','akun'])->paginate(10);
    }

    public function show($id)
    {
        //
    }

    public function laporanKartuKredit(Request $request){

      $kartu_kredit = $request->kartu_kredit;
      $dariTanggal = $request->dariTanggal;
      $sampaiTanggal = $request->sampaiTanggal;

      $laporan = TransaksiKartuKredit::with(['kartu_kredit','akun'])
                ->where('kartu_kredit',$kartu_kredit)
               ->where(function($query) use ($dariTanggal,$sampaiTanggal){
                  $query
                   ->whereDate('transaksi_kartu_kredit.created_at','>=',$dariTanggal)
                   ->whereDate('transaksi_kartu_kredit.created_at','<=',$sampaiTanggal);
               })
               ->paginate(10);
      return $laporan;

    }

    public function storeKartuKreditMasuk(Request $request)
    {
        $request->validate([
            'kartu_kredit' => 'required|numeric',
            'akun' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $noTrans = TransaksiKartuKredit::noTrans();
        $transaksiKartuKredit = TransaksiKartuKredit::create([
          'no_trans' => $noTrans,
          'kartu_kredit' => $request->kartu_kredit,
          'akun' => $request->akun,
          'masuk' => $request->jumlah,
          'deskripsi' => $request->deskripsi
        ]);
        if($transaksiKartuKredit){
          return response(200);
        } else {
          return response(500);
        }
    }
    public function storeKartuKreditKeluar(Request $request)
    {
        $request->validate([
            'kartu_kredit' => 'required|numeric',
            'akun' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $noTrans = TransaksiKartuKredit::noTrans();
        $transaksiKartuKredit = TransaksiKartuKredit::create([
          'no_trans' => $noTrans,
          'kartu_kredit' => $request->kartu_kredit,
          'akun' => $request->akun,
          'keluar' => $request->jumlah,
          'deskripsi' => $request->deskripsi
        ]);
        if($transaksiKartuKredit){
          return response(200);
        } else {
          return response(500);
        }
    }

    public function search(Request $request){

        $transaksiKartuKredit = TransaksiKartuKredit::Where('deskripsi','LIKE',"%$request->q%")->paginate(10);
        return $transaksiKartuKredit;
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
        return TransaksiKartuKredit::find($id);
    }

    public function updateKartuKreditMasuk(Request $request, $id){

        $request->validate([
            'kartu_kredit' => 'required|numeric',
            'akun' => 'required|numeric',
            'masuk' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $transaksiKartuKredit = TransaksiKartuKredit::find($id)->update($request->all());
        if($transaksiKartuKredit){
          return response(200);
        } else {
          return response()->status(500);
        }
    }
    public function updateKartuKreditKeluar(Request $request, $id){

        $request->validate([
            'kartu_kredit' => 'required|numeric',
            'akun' => 'required|numeric',
            'keluar' => 'required|numeric',
            'deskripsi' => 'max:255'
        ]);
        $transaksiKartuKredit = TransaksiKartuKredit::find($id)->update($request->all());
        if($transaksiKartuKredit){
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
        $transaksiKartuKredit = TransaksiKartuKredit::destroy($id);
        if($transaksiKartuKredit){
          return response(200);
        } else {
          return response(500);
        }
    }
}
