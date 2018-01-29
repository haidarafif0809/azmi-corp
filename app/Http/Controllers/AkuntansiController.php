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

    public function bukuBesar(Request $request){
      
      $dariTanggal = $request->dariTanggal;
      $sampaiTanggal = $request->sampaiTanggal;
      $akun = $request->akun;
      $detailJurnal = DetailTransaksiJurnal::leftJoin('akuns','akuns.id','detail_transaksi_jurnals.akun_id')
                      ->select('detail_transaksi_jurnals.*','akuns.nama AS nama_akun')
                      ->where('akun_id',$akun)
                      ->whereDate('detail_transaksi_jurnals.created_at','>=',$dariTanggal)
                      ->whereDate('detail_transaksi_jurnals.created_at','<=',$sampaiTanggal)
                      ->paginate(10);
      $sumDebit = DetailTransaksiJurnal::where('akun_id',$akun)
                      ->whereDate('detail_transaksi_jurnals.created_at','>=',$dariTanggal)
                      ->whereDate('detail_transaksi_jurnals.created_at','<=',$sampaiTanggal)
                      ->sum('debit');
      $sumKredit = DetailTransaksiJurnal::where('akun_id',$akun)
                      ->whereDate('detail_transaksi_jurnals.created_at','>=',$dariTanggal)
                      ->whereDate('detail_transaksi_jurnals.created_at','<=',$sampaiTanggal)
                      ->sum('kredit');
      $saldoAkun = $sumDebit - $sumKredit;
      $totalNilai = collect(['total_nilai' => $saldoAkun]);
      $data = $totalNilai->merge($detailJurnal);
      return $data;
    
    }

    public function neraca(Request $request) {
      $tanggal = $request->sampaiTanggal;
      $nilaiKas = $this->dapatkanNilaiAkunAktiva('kas',$tanggal); 
      $nilaiPiutang = $this->dapatkanNilaiAkunAktiva('piutang',$tanggal); 
      $nilaiPersediaan = $this->dapatkanNilaiAkunAktiva('persediaan',$tanggal);
      $nilaiAktivaTetap = $this->dapatkanNilaiAkunAktiva('aktiva_tetap',$tanggal);
      $nilaiAktiva = $nilaiKas + $nilaiPersediaan + $nilaiPiutang + $nilaiAktivaTetap;
      $nilaiHutang = $this->dapatkanNilaiAkunPasiva('hutang',$tanggal); 
      $nilaiModal = $this->dapatkanNilaiAkunPasiva('modal',$tanggal); 
      $nilaiBiaya = $this->dapatkanNilaiAkunAktiva('biaya',$tanggal);
      $nilaiPenjualan = $this->dapatkanNilaiAkunPasiva('penjualan',$tanggal);
      $nilaiLabaBerjalan = $nilaiPenjualan - $nilaiBiaya;
      $nilaiPasiva = $nilaiModal + $nilaiLabaBerjalan + $nilaiHutang;
      $akunKas = $this->dapatkanAkunDanNilai('kas',$tanggal,'aktiva');
      $akunPiutang = $this->dapatkanAkunDanNilai('piutang',$tanggal,'aktiva');
      $akunPersediaan = $this->dapatkanAkunDanNilai('persediaan',$tanggal,'aktiva');
      $akunAktivaTetap = $this->dapatkanAkunDanNilai('aktiva_tetap',$tanggal,'aktiva');
      $akunHutang = $this->dapatkanAkunDanNilai('hutang',$tanggal,'pasiva');
      $akunModal = $this->dapatkanAkunDanNilai('modal',$tanggal,'pasiva');
      $neraca = ['kas' => $nilaiKas,
                 'akun_kas' => $akunKas,
                 'akun_wkwk' => $akunPersediaan,
                 'piutang' => $nilaiPiutang,
                 'akun_piutang' => $akunPiutang,
                 'persediaan' => $nilaiPersediaan,
                 'akun_punya_persediaan ' => $akunPersediaan,
                 'aktiva_tetap' => $nilaiAktivaTetap,
                 'akun_aktiva_tetap' => $akunAktivaTetap,
                 'nilai_aktiva' => $nilaiAktiva,
                 'nilai_pasiva' => $nilaiPasiva,
                 'hutang' => $nilaiHutang,
                 'akun_hutang' => $akunHutang,
                 'modal' => $nilaiModal,
                 'akun_modal' => $akunModal,
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
    private function dapatkanAkunDanNilai($jenis,$tanggal,$aktivaPasiva){
      $akuns = Akun::where('jenis',$jenis)->get();
      $akunNilai = [];
      foreach($akuns as $akun){
             
        $jurnal = DetailTransaksiJurnal::where('akun_id',$akun->id)
                       ->whereDate('created_at','<=',$tanggal);
        $sumDebit = $jurnal->sum('debit');
        $sumKredit = $jurnal->sum('kredit');
        if($aktivaPasiva == 'aktiva'){
          $saldo = $sumDebit - $sumKredit;    
        } else {
          $saldo = $sumKredit - $sumDebit;    
        }
        array_push($akunNilai,['akun' => $akun->nama,'saldo' => $saldo]);
      }
      return $akunNilai;
        
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
