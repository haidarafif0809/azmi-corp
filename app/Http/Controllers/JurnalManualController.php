<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JurnalManual;
use App\Akun;

class JurnalManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return JurnalManual::leftJoin('akuns as akun_yang_debit',
               'jurnal_manuals.akun_debit','=','akun_yang_debit.id')
               ->leftJoin('akuns as akun_yang_kredit',
               'jurnal_manuals.akun_kredit','=','akun_yang_kredit.id')
               ->select('jurnal_manuals.*','akun_yang_debit.nama as nama_akun_debitt',
               'akun_yang_kredit.nama as nama_akun_kredit')
               ->paginate(10);
    }

    public function laporanKas(Request $request){
      
      $kas = $request->kas;
      $dariTanggal = $request->dariTanggal;
      $sampaiTanggal = $request->sampaiTanggal;
      
      $laporan = JurnalManual::leftJoin('akuns as akun_yang_masuk',
               'transaksi_kas.akun_debit','=','akun_yang_masuk.id')
               ->leftJoin('akuns as akun_yang_keluar',
               'transaksi_kas.akun_kredit','=','akun_yang_keluar.id')
               ->select('transaksi_kas.*','akun_yang_masuk.nama as nama_akun_debit',
               'akun_yang_keluar.nama as nama_akun_keluar')
                ->where('akun_debit',$kas)
               ->orWhere('akun_kredit',$kas)
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
    public function store(Request $request)
    {
        //
        $request->validate([
            'akun_debit' => 'required|numeric',
            'akun_kredit' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'nullable|max:255'
        ]);
        $noTrans = JurnalManual::noJurnalManual();
        $request->request->add(['no_trans' => $noTrans] );
        $jurnalManual = JurnalManual::create($request->all());
        if($jurnalManual){
          return response(200);    
        } else {
          return response(500);    
        }
    }
    
    public function search(Request $request){
          
        $jurnalManual = JurnalManual::where('id',$request->q)
                          ->orWhere('deskripsi','LIKE',"%$request->q%")
                          ->paginate(10);
        return $jurnalManual;
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
        return JurnalManual::find($id);
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
            'akun_debit' => 'required|numeric',
            'akun_kredit' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'nullable|max:255'
        ]);
       
        $jurnalManual = JurnalManual::find($id)->update($request->all());
        if($jurnalManual){
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
        $jurnalManual = JurnalManual::destroy($id);
        if($jurnalManual){
          return response(200);    
        } else {
          return response(500);
        }
    }
}
