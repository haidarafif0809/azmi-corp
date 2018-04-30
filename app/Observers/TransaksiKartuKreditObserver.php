<?php

namespace App\Observers;

use App\TransaksiKartuKredit;
use App\TransaksiJurnal;
use App\DetailTransaksiJurnal;

class TransaksiKartuKreditObserver
{
    /**
     * Listen to the TransaksiKartuKredit created event.
     *
     * @param  \App\TransaksiKartuKredit  $transaksiKartuKredit
     * @return void
     */
    public function created(TransaksiKartuKredit $transaksiKartuKredit)
    {
        //
        $noJurnal = TransaksiJurnal::noJurnal();
        $noTrans = $transaksiKartuKredit->no_trans;
        $jumlahAkun = 2;
        if($transaksiKartuKredit->masuk == 0){
        $jenisTrans = 'kartu_kredit_keluar';
        $totalNilai = $transaksiKartuKredit->keluar;
        $akunDebit = $transaksiKartuKredit->akun;
        $akunKredit = $transaksiKartuKredit->kartu_kredit;
        $nilaiDebitKredit = $transaksiKartuKredit->keluar;
        } else {
        $jenisTrans = 'kartu_kredit_masuk';
        $totalNilai = $transaksiKartuKredit->masuk;
        $akunDebit = $transaksiKartuKredit->kartu_kredit;
        $akunKredit = $transaksiKartuKredit->akun;
        $nilaiDebitKredit = $transaksiKartuKredit->masuk;
        }
        $deskripsi = $transaksiKartuKredit->deskripsi;

        $transaksiDebit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiKartuKredit->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunDebit,
                                                       'deskripsi' => $deskripsi,
                                                       'jenis_trans' => $jenisTrans,
                                                       'debit' => $nilaiDebitKredit,
                                                       'kredit' => 0 ]);
        $transaksiKredit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiKartuKredit->id,
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


    public function updated(TransaksiKartuKredit $transaksiKartuKredit){
        //hapus dulu jurnal yang lama
        $transaksiJurnal = TransaksiJurnal::where('no_trans',$transaksiKartuKredit->no_trans)->delete();
        $detailTransaksiJurnal = DetailTransaksiJurnal::where('no_trans',$transaksiKartuKredit->no_trans)->delete();
        $noJurnal = TransaksiJurnal::noJurnal();
        // persiapkan variable yang dibutuhkan
        $noTrans = $transaksiKartuKredit->no_trans;
        $jumlahAkun = 2;
        if($transaksiKartuKredit->masuk == 0){
        $jenisTrans = 'kartu_kredit_keluar';
        $totalNilai = $transaksiKartuKredit->keluar;
        $akunDebit = $transaksiKartuKredit->akun;
        $akunKredit = $transaksiKartuKredit->kartu_kredit;
        $nilaiDebitKredit = $transaksiKartuKredit->keluar;
        } else {
        $jenisTrans = 'kartu_kredit_masuk';
        $totalNilai = $transaksiKartuKredit->masuk;
        $akunDebit = $transaksiKartuKredit->kartu_kredit;
        $akunKredit = $transaksiKartuKredit->akun;
        $nilaiDebitKredit = $transaksiKartuKredit->masuk;
        }
        $deskripsi = $transaksiKartuKredit->deskripsi;
        //transaksi detail debit dan kredit nya
        $transaksiDebit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiKartuKredit->id,
                                                       'no_trans' => $noTrans,
                                                       'akun_id' => $akunDebit,
                                                       'jenis_trans' => $jenisTrans,
                                                       'debit' => $nilaiDebitKredit,
                                                       'kredit' => 0 ]);
        $transaksiKredit = DetailTransaksiJurnal::create(['no_jurnal' => $noJurnal,
                                                       'trans_id' => $transaksiKartuKredit->id,
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
     * Listen to the TransaksiKartuKredit deleting event.
     *
     * @param  \App\TransaksiKartuKredit  $transaksiKartuKredit
     * @return void
     */
    public function deleting(TransaksiKartuKredit $transaksiKartuKredit)
    {
        //
        $transaksiJurnal = TransaksiJurnal::where('no_trans',$transaksiKartuKredit->no_trans)->delete();
        $detailTransaksiJurnal = DetailTransaksiJurnal::where('no_trans',$transaksiKartuKredit->no_trans)->delete();
        if($transaksiJurnal && $detailTransaksiJurnal){
          return true;
        } else {
          return false;
        }
    }
}
