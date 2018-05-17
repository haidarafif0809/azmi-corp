<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiGasMasuk extends Model
{
    //
    protected $fillable = ['produk_id','nama','kode_produk','kosong_p','kosong_r',
                            'kosong_k','isi','no_rute','transaksi_gas_id'];
}
