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
    public function created(TransaksiGas $transaksiGas)
    {
        //
    }


    public function updated(TransaksiGas $transaksiGas){
        //hapus dulu jurnal yang lama
    }

    /**
     * Listen to the TransaksiGas deleting event.
     *
     * @param  \App\TransaksiGas  $transaksiGas
     * @return void
     */
    public function deleting(TransaksiGas $transaksiGas)
    {
        //
    }
}
