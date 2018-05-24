<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransaksiLain extends Model
{
    //
    protected $fillable = ['no_trans','no_rute','akun_debit','akun_kredit','jumlah'];

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

    $transaksiLain = TransaksiLain::select([DB::raw('MONTH(created_at) bulan'),'no_trans'])
                      ->orderBy('id','DESC')->first();
    if($transaksiLain != null){
      $angkaNoLain = explode("/",$transaksiLain->no_trans);
      $nomor = $angkaNoLain[0];
      $bulanAkhir = $transaksiLain->bulan;
    } else {
      $nomor = 1;
      $bulanAkhir = 13;
    }
    if($bulanAkhir != $bulanSekarang ){
      $noTrans = "1/TL/". $bulanTerakhir . "/".$tahunTerakhir;
    } else {
      $nomor++;
      $noTrans = $nomor . "/TL/". $bulanTerakhir ."/". $tahunTerakhir;
    }
    return $noTrans;
   }
}
