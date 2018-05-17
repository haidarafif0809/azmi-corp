<?php

namespace App\Observers;

use App\TransaksiGas;
use App\TransaksiKas;

class TransaksiGasObserver
{
    /**
     * Listen to the TransaksiGas created event.
     *
     * @param  \App\TransaksiGas  $transaksiGas
     * @return void
     */
    public function creating(TransaksiGas $transaksiGas)
    {
        if ($transaksiGas->status_barang == 'masuk') {
          $transaksiKas = TransaksiKas::create([
            'no_trans' => $transaksiGas->no_kas,
            'akun_masuk' => $transaksiGas->akun_masuk,
            'akun_keluar' => $transaksiGas->akun_keluar,
            'masuk' => $transaksiGas->uang_jalan,
            'deskripsi' => $transaksiGas->deskripsi
          ]);
        } else {
          $transaksiKas = TransaksiKas::create([
            'no_trans' => $transaksiGas->no_kas,
            'akun_masuk' => $transaksiGas->akun_masuk,
            'akun_keluar' => $transaksiGas->akun_keluar,
            'keluar' => $transaksiGas->uang_jalan,
            'deskripsi' => $transaksiGas->deskripsi
          ]);

        }
    }


    public function updated(TransaksiGas $transaksiGas){
    }

    /**
     * Listen to the TransaksiGas deleting event.
     *
     * @param  \App\TransaksiGas  $transaksiGas
     * @return void
     */
    public function deleted(TransaksiGas $transaksiGas)
    {
        //
        $transaksiKas = TransaksiKas::where('no_trans',$transaksiGas->no_kas)->first();
        TransaksiKas::destroy($transaksiKas->id);

    }
}
