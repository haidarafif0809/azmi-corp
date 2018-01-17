<?php

namespace App\Observers;

use App\TransaksiKas;
use App\TransaksiJurnal;
use App\DetailTransaksiJurnal;

class TransaksiKasObserver
{
    /**
     * Listen to the TransaksiKas created event.
     *
     * @param  \App\TransaksiKas  $transaksiKas
     * @return void
     */
    public function created(TransaksiKas $transaksiKas)
    {
        //
        $noJurnal = TransaksiJurnal::noJurnal();
        $noTrans = $transaksiKas->no_trans;
        $jumlahAkun = 2;
        if($transaksiKas->masuk == 0){ 
        $jenisTrans = 'kas_keluar';
        $totalNilai = $transaksiKas->keluar;
        $akunDebit = $transaksiKas->akun_masuk;
        $akunKredit = $transaksiKas->akun_keluar;
        $nilaiDebitKredit = $transaksiKas->keluar;
        } else {
        $jenisTrans = 'kas_masuk';
        $totalNilai = $transaksiKas->masuk;
        $akunDebit = $transaksiKas->akun_keluar;
        $akunKredit = $transaksiKas->akun_masuk;
        $nilaiDebitKredit = $transaksiKas->masuk;
        }
        $deskripsi = $transaksiKas->deskripsi;
       
        $transaksiDebit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiKas->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunDebit,
                                                       'jenis_trans' => $jenisTrans,
                                                       'debit' => $nilaiDebitKredit,
                                                       'kredit' => 0 ]);
        $transaksiKredit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiKas->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunKredit,
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


    public function updated(TransaksiKas $transaksiKas){
        //hapus dulu jurnal yang lama
        $transaksiJurnal = TransaksiJurnal::where('no_trans',$transaksiKas->no_trans)->delete();
        $detailTransaksiJurnal = DetailTransaksiJurnal::where('no_trans',$transaksiKas->no_trans)->delete();
        $noJurnal = TransaksiJurnal::noJurnal();
        // persiapkan variable yang dibutuhkan
        $noTrans = $transaksiKas->no_trans;
        $jumlahAkun = 2;
        if($transaksiKas->masuk == 0){ 
        $jenisTrans = 'kas_keluar';
        $totalNilai = $transaksiKas->keluar;
        $akunDebit = $transaksiKas->akun_masuk;
        $akunKredit = $transaksiKas->akun_keluar;
        $nilaiDebitKredit = $transaksiKas->keluar;
        } else {
        $jenisTrans = 'kas_masuk';
        $totalNilai = $transaksiKas->masuk;
        $akunDebit = $transaksiKas->akun_keluar;
        $akunKredit = $transaksiKas->akun_masuk;
        $nilaiDebitKredit = $transaksiKas->masuk;
        }
        $deskripsi = $transaksiKas->deskripsi;
        //transaksi detail debit dan kredit nya
        $transaksiDebit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiKas->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunDebit,
                                                       'jenis_trans' => $jenisTrans,
                                                       'debit' => $nilaiDebitKredit,
                                                       'kredit' => 0 ]);
        $transaksiKredit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiKas->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunKredit,
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

    /**
     * Listen to the TransaksiKas deleting event.
     *
     * @param  \App\TransaksiKas  $transaksiKas
     * @return void
     */
    public function deleting(TransaksiKas $transaksiKas)
    {
        //
        $transaksiJurnal = TransaksiJurnal::where('no_trans',$transaksiKas->no_trans)->delete();
        $detailTransaksiJurnal = DetailTransaksiJurnal::where('no_trans',$transaksiKas->no_trans)->delete();
        if($transaksiJurnal && $detailTransaksiJurnal){
          return response(200);    
        } else {
          return response()->status(500);    
        }
    }
}
