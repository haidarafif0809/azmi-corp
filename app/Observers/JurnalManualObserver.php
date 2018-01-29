<?php

namespace App\Observers;

use App\JurnalManual;
use App\TransaksiJurnal;
use App\DetailTransaksiJurnal;

class JurnalManualObserver
{
    /**
     * Listen to the JurnalManual created event.
     *
     * @param  \App\JurnalManual  $jurnalManual
     * @return void
     */
    public function created(JurnalManual $jurnalManual)
    {
        //
        $noJurnal = TransaksiJurnal::noJurnal();
        $noTrans = $jurnalManual->no_trans;
        $jumlahAkun = 2;
        $jenisTrans = 'jurnal_manual';
        $totalNilai = $jurnalManual->jumlah;
        $akunDebit = $jurnalManual->akun_debit;
        $akunKredit = $jurnalManual->akun_kredit;
        $nilaiDebitKredit = $jurnalManual->jumlah;
        $deskripsi = $jurnalManual->deskripsi;
       
        $transaksiDebit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $jurnalManual->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunDebit,
                                                       'deskripsi' => $deskripsi,
                                                       'jenis_trans' => $jenisTrans,
                                                       'debit' => $nilaiDebitKredit,
                                                       'kredit' => 0 ]);
        $transaksiKredit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $jurnalManual->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunKredit,
                                                       'deskripsi' => $deskripsi,
                                                       'jenis_trans' => $jenisTrans,
                                                       'kredit' => $nilaiDebitKredit,
                                                       'debit' => 0
                                                       ]);
        $transaksiJurnal = TransaksiJurnal::create(['no_jurnal' => $noJurnal,'no_trans' => $noTrans,
                                 'jumlah_akun' => $jumlahAkun,'jenis_trans' => $jenisTrans,
                                 'deskripsi' => $deskripsi,'total_nilai' => $totalNilai]);       
        if($transaksiJurnal && $transaksiKredit && $transaksiKredit){
          return true;    
        } else {
          return false;    
        }
    }


    public function updated(JurnalManual $jurnalManual){
        //hapus dulu jurnal yang lama
        $transaksiJurnal = TransaksiJurnal::where('no_trans',$jurnalManual->no_trans)->delete();
        $detailTransaksiJurnal = DetailTransaksiJurnal::where('no_trans',$jurnalManual->no_trans)->delete();
        $noJurnal = TransaksiJurnal::noJurnal();
        // persiapkan variable yang dibutuhkan
        $noTrans = $jurnalManual->no_trans;
        $jumlahAkun = 2;
        $jenisTrans = 'jurnal_manual';
        $totalNilai = $jurnalManual->jumlah;
        $akunDebit = $jurnalManual->akun_debit;
        $akunKredit = $jurnalManual->akun_kredit;
        $nilaiDebitKredit = $jurnalManual->jumlah;
        $deskripsi = $jurnalManual->deskripsi;
       
        $transaksiDebit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $jurnalManual->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunDebit,
                                                       'deskripsi' => $deskripsi,
                                                       'jenis_trans' => $jenisTrans,
                                                       'debit' => $nilaiDebitKredit,
                                                       'kredit' => 0 ]);
        $transaksiKredit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $jurnalManual->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunKredit,
                                                       'deskripsi' => $deskripsi,
                                                       'jenis_trans' => $jenisTrans,
                                                       'kredit' => $nilaiDebitKredit,
                                                       'debit' => 0
                                                       ]);
        //transaksi detail debit dan kredit nya
        $transaksiJurnal = TransaksiJurnal::create(['no_jurnal' => $noJurnal,'no_trans' => $noTrans,
                                 'jumlah_akun' => $jumlahAkun,'jenis_trans' => $jenisTrans,
                                 'deskripsi' => $deskripsi,'total_nilai' => $totalNilai]);       
        if($transaksiJurnal && $transaksiKredit && $transaksiKredit){
          return true;    
        } else {
          return false;    
        }
    
    }

    /**
     * Listen to the JurnalManual deleting event.
     *
     * @param  \App\JurnalManual  $jurnalManual
     * @return void
     */
    public function deleting(JurnalManual $jurnalManual)
    {
        //
        $transaksiJurnal = TransaksiJurnal::where('no_trans',$jurnalManual->no_trans)->delete();
        $detailTransaksiJurnal = DetailTransaksiJurnal::where('no_trans',$jurnalManual->no_trans)->delete();
        if($transaksiJurnal && $detailTransaksiJurnal){
          return response(200);    
        } else {
          return response(500);    
        }
    }
}
