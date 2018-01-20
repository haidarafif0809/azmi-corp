<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiJurnal extends Model
{
    //
    protected $fillable = ['no_jurnal','trans_id','no_trans','akun_id','jenis_trans','debit','kredit','deskripsi'];
}
