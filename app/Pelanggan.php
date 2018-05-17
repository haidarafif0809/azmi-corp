<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    //
    protected $fillable = ['kode','nama','kontak','alamat','email','alamat_kantor','perusahaan', 'koordinat'];
}
