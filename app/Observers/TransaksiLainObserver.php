<?php

namespace App\Observers;

use App\TransaksiLain;
use App\TransaksiJurnal;
use App\DetailTransaksiJurnal;

class TransaksiLainObserver
{
    /**
     * Listen to the TransaksiLain created event.
     *
     * @param  \App\TransaksiLain  $transaksiLain
     * @return void
     */
    public function created(TransaksiLain $transaksiLain)
    {
        //
        $noJurnal = TransaksiJurnal::noJurnal();
        $noTrans = $transaksiLain->no_trans;
        $jumlahAkun = 2;
        $jenisTrans = 'transaksi_lain';
        $totalNilai = $transaksiLain->jumlah;
        $akunDebit = $transaksiLain->akun_debit;
        $akunKredit = $transaksiLain->akun_kredit;
        $nilaiDebitKredit = $transaksiLain->jumlah;
        $deskripsi = '';

        $transaksiDebit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiLain->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunDebit,
                                                       'deskripsi' => $deskripsi,
                                                       'jenis_trans' => $jenisTrans,
                                                       'debit' => $nilaiDebitKredit,
                                                       'kredit' => 0 ]);
        $transaksiKredit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiLain->id,
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


    public function updated(TransaksiLain $transaksiLain){
        //hapus dulu jurnal yang lama
        $transaksiJurnal = TransaksiJurnal::where('no_trans',$transaksiLain->no_trans)->delete();
        $detailTransaksiJurnal = DetailTransaksiJurnal::where('no_trans',$transaksiLain->no_trans)->delete();
        $noJurnal = TransaksiJurnal::noJurnal();
        // persiapkan variable yang dibutuhkan
        $noTrans = $transaksiLain->no_trans;
        $jumlahAkun = 2;
        $jenisTrans = 'transaksi_lain';
        $totalNilai = $transaksiLain->jumlah;
        $akunDebit = $transaksiLain->akun_debit;
        $akunKredit = $transaksiLain->akun_kredit;
        $nilaiDebitKredit = $transaksiLain->jumlah;
        $deskripsi = '';
        //transaksi detail debit dan kredit nya
        $transaksiDebit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiLain->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunDebit,
                                                       'jenis_trans' => $jenisTrans,
                                                       'debit' => $nilaiDebitKredit,
                                                       'kredit' => 0 ]);
        $transaksiKredit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiLain->id,
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
     * Listen to the TransaksiLain deleting event.
     *
     * @param  \App\TransaksiLain  $transaksiLain
     * @return void
     */
    public function deleting(TransaksiLain $transaksiLain)
    {
        //
        $transaksiJurnal = TransaksiJurnal::where('no_trans',$transaksiLain->no_trans)->delete();
        $detailTransaksiJurnal = DetailTransaksiJurnal::where('no_trans',$transaksiLain->no_trans)->delete();
        if($transaksiJurnal && $detailTransaksiJurnal){
          return true;
        } else {
          return false;
        }
    }
}
