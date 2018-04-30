<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransaksiKartuKredit extends Model
{
    //
   protected $fillable = ['no_trans','kartu_kredit','akun','deskripsi','masuk','keluar'];

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

    $transaksiKartuKredit = TransaksiKartuKredit::select([DB::raw('MONTH(created_at) bulan'),'no_trans'])
                      ->orderBy('id','DESC')->first();
    if($transaksiKartuKredit != null){
      $angkaNoKartuKredit = explode("/",$transaksiKartuKredit->no_trans);
      $nomor = $angkaNoKartuKredit[0];
      $bulanAkhir = $transaksiKartuKredit->bulan;
    } else {
      $nomor = 1;
      $bulanAkhir = 13;
    }
    if($bulanAkhir != $bulanSekarang ){
      $noTrans = "1/KRT/". $bulanTerakhir . "/".$tahunTerakhir;
    } else {
      $nomor++;
      $noTrans = $nomor . "/KRT/". $bulanTerakhir ."/". $tahunTerakhir;
    }
    return $noTrans;
   }

    public function kartu_kredit()
    {
        return $this->belongsTo('App\Akun','kartu_kredit');
    }
    public function akun()
    {
        return $this->belongsTo('App\Akun','akun');
    }
}
