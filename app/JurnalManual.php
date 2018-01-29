<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JurnalManual extends Model
{
    //
   protected $fillable = ['no_trans','akun_debit','akun_kredit','deskripsi','jumlah'];

   public static function noJurnalManual(){
     $tahunSekarang = date('Y');
     $bulanSekarang = date('m');
     $tahunTerakhir = substr($tahunSekarang,2);
     $digitBulan = strlen($bulanSekarang);
     if($digitBulan == 1){
       $bulanTerakhir = "0".$bulanSekarang;
     } else {
       $bulanTerakhir = $bulanSekarang;     
    }

    $transaksiJurnalManual = JurnalManual::select([DB::raw('MONTH(created_at) bulan'),'no_trans'])
                      ->orderBy('id','DESC')->first();
    if($transaksiJurnalManual != null){
      $angkaNoJurnalManual = explode("/",$transaksiJurnalManual->no_trans);
      $nomor = $angkaNoJurnalManual[0];
      $bulanAkhir = $transaksiJurnalManual->bulan;
    } else {
      $nomor = 1;
      $bulanAkhir = 13;
    }
    if($bulanAkhir != $bulanSekarang ){
      $noJurnalManual = "1/JRM/". $bulanTerakhir . "/".$tahunTerakhir;      
    } else {
      $nomor++;
      $noJurnalManual = $nomor . "/JRM/". $bulanTerakhir ."/". $tahunTerakhir;     
    }
    return $noJurnalManual;

   }
}
