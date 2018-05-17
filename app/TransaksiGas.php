<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransaksiGas extends Model
{
    //
    protected $fillable = [
      'no_rute','mobil',
      'status_barang','asal_barang',
      'tujuan_barang','driver',
      'uang_jalan','akun_masuk','akun_keluar',
      'no_kas'
    ];

    public static function noRute(){

     $tahunSekarang = date('Y');
     $bulanSekarang = date('m');
     $tahunTerakhir = substr($tahunSekarang,2);
     $digitBulan = strlen($bulanSekarang);
     if($digitBulan == 1){
       $bulanTerakhir = "0".$bulanSekarang;
     } else {
       $bulanTerakhir = $bulanSekarang;
    }

    $transaksiGas = TransaksiGas::select([DB::raw('MONTH(created_at) bulan'),'no_rute'])
                      ->orderBy('id','DESC')->first();
    if($transaksiGas != null){
      $angkaNoGas = explode("/",$transaksiGas->no_rute);
      $nomor = $angkaNoGas[0];
      $bulanAkhir = $transaksiGas->bulan;
    } else {
      $nomor = 1;
      $bulanAkhir = 13;
    }
    if($bulanAkhir != $bulanSekarang ){
      $noGas = "1/RT/". $bulanTerakhir . "/".$tahunTerakhir;
    } else {
      $nomor++;
      $noGas = $nomor . "/RT/". $bulanTerakhir ."/". $tahunTerakhir;
    }
    return $noGas;
    }
}
