<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiKas extends Model
{
    //
    protected $fillable = ['akun_masuk','akun_keluar','deskripsi','masuk','keluar'];
}
