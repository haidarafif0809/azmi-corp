<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransaksiJurnal;
use App\DetailTransaksiJurnal;
use App\Akun;

class AkuntansiController extends Controller
{
    //
    public function jurnalUmum(Request $request){
      
      $dariTanggal = $request->dariTanggal;
      $sampaiTanggal = $request->sampaiTanggal;
      $detailJurnal = DetailTransaksiJurnal::leftJoin('akuns','akuns.id','detail_transaksi_jurnals.akun_id')
                      ->select('detail_transaksi_jurnals.*','akuns.nama AS nama_akun')
                      ->whereDate('detail_transaksi_jurnals.created_at','>=',$dariTanggal)
                      ->whereDate('detail_transaksi_jurnals.created_at','<=',$sampaiTanggal)
                      ->paginate(10);
      return $detailJurnal;
    
    }

    public function neraca(Request $request) {
      $tanggal = $request->sampaiTanggal;
      $nilaiKas = $this->dapatkanNilaiAkunAktiva('kas',$tanggal); 
      $nilaiPiutang = $this->dapatkanNilaiAkunAktiva('piutang',$tanggal); 
      $nilaiPersediaan = $this->dapatkanNilaiAkunAktiva('persediaan',$tanggal);
      $nilaiAktiva = $nilaiKas + $nilaiPersediaan + $nilaiPiutang;
      $nilaiHutang = $this->dapatkanNilaiAkunPasiva('hutang',$tanggal); 
      $nilaiModal = $this->dapatkanNilaiAkunPasiva('modal',$tanggal); 
      $nilaiBiaya = $this->dapatkanNilaiAkunAktiva('biaya',$tanggal);
      $nilaiPenjualan = $this->dapatkanNilaiAkunPasiva('penjualan',$tanggal);
      $nilaiLabaBerjalan = $nilaiPenjualan - $nilaiBiaya;
      $nilaiPasiva = $nilaiModal + $nilaiLabaBerjalan + $nilaiHutang;

      $neraca = ['kas' => $nilaiKas,
                 'piutang' => $nilaiPiutang,
                 'persediaan' => $nilaiPersediaan,
                 'nilai_aktiva' => $nilaiAktiva,
                 'nilai_pasiva' => $nilaiPasiva,
                 'hutang' => $nilaiHutang,
                 'modal' => $nilaiModal,
                 'laba_rugi' => $nilaiLabaBerjalan,
                 'penjualan' => $nilaiPenjualan,
                 'biaya' => $nilaiBiaya,
                 ];


      return $neraca; 
    }
    
    public function labaRugi(Request $request){
      $tanggal = $request->sampaiTanggal;
      $dariTanggal = $request->dariTanggal;
      $nilaiBiaya = $this->dapatkanNilaiAkunAktiva('biaya',$tanggal,$dariTanggal);
      $nilaiHpp = $this->dapatkanNilaiAkunAktiva('hpp',$tanggal,$dariTanggal);
      $nilaiPenjualan = $this->dapatkanNilaiAkunPasiva('penjualan',$tanggal,$dariTanggal);
      $nilaiLabaBerjalan = $nilaiPenjualan - $nilaiBiaya - $nilaiHpp;
      $labaRugi = ['biaya' => $nilaiBiaya,
                   'penjualan' => $nilaiPenjualan,
                   'hpp' => $nilaiHpp,
                   'laba_rugi' => $nilaiLabaBerjalan
                   ];
     return $labaRugi;

      
    }
    private function dapatkanNilaiAkunPasiva($jenis,$tanggal,$dariTanggal = ''){
        
      $idAkunPasiva = $this->dapatkanIdAkunPerJenis($jenis);
      if($dariTanggal != ''){
      $pasivaJurnal = DetailTransaksiJurnal::whereIn('akun_id',$idAkunPasiva)
                       ->whereDate('created_at','>=',$dariTanggal)
                       ->whereDate('created_at','<=',$tanggal);          
      } else {    
      $pasivaJurnal = DetailTransaksiJurnal::whereIn('akun_id',$idAkunPasiva)
                       ->whereDate('created_at','<=',$tanggal);
      }
      $pasivaJurnal = DetailTransaksiJurnal::whereIn('akun_id',$idAkunPasiva)
                       ->whereDate('created_at','<=',$tanggal);
      $pasivaDebit = $pasivaJurnal->sum('debit');
      $pasivaKredit = $pasivaJurnal->sum('kredit');
      $nilaiPasiva =  $pasivaKredit - $pasivaDebit;
      return $nilaiPasiva;
    }
    private function dapatkanNilaiAkunAktiva($jenis,$tanggal,$dariTanggal = ''){
        
      $idAkunAktiva = $this->dapatkanIdAkunPerJenis($jenis);
      $aktivaJurnal = DetailTransaksiJurnal::whereIn('akun_id',$idAkunAktiva)
                       ->whereDate('created_at','<=',$tanggal);
      $aktivaDebit = $aktivaJurnal->sum('debit');
      $aktivaKredit = $aktivaJurnal->sum('kredit');
      $nilaiAktiva = $aktivaDebit - $aktivaKredit;
      return $nilaiAktiva;
    }

    private function dapatkanIdAkunPerJenis($jenis){
     
      $akun = Akun::where('jenis',$jenis)->select('id')->get();
      $idAkun = [];
      foreach($akun as $akun){
        array_push($idAkun,$akun->id);    
      }
      return $idAkun; 
    }

}
