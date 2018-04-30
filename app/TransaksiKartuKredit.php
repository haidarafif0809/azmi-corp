<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiKartuKredit extends Model
{
    //
   protected $fillable = ['no_trans','kartu_kredit','akun_keluar','deskripsi','masuk','keluar'];
   
   public static function noTrans(){
     $tahunSekarang = date('Y');
     $bulanSekarang = date('m');
     $tahunTerakhir = substr($tahunSekarang,2);
     $digitBulan = strlen($bulanSekarang);
     if($digitBulan == 1){
       $bulanTerakhir = "0".$bulanSekarang;
     } else {
       $bulanTerakhir = $bulanSekarang;     
    }

    $transaksiKas = TransaksiKas::select([DB::raw('MONTH(created_at) bulan'),'no_trans'])
                      ->orderBy('id','DESC')->first();
    if($transaksiKas != null){
      $angkaNoKas = explode("/",$transaksiKas->no_trans);
      $nomor = $angkaNoKas[0];
      $bulanAkhir = $transaksiKas->bulan;
    } else {
      $nomor = 1;
      $bulanAkhir = 13;
    }
    if($bulanAkhir != $bulanSekarang ){
      $noTrans = "1/KS/". $bulanTerakhir . "/".$tahunTerakhir;      
    } else {
      $nomor++;
      $noTrans = $nomor . "/KS/". $bulanTerakhir ."/". $tahunTerakhir;     
    }
    return $noTrans;
   }
}
