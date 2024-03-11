<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanJasaModel extends Model
{
    use HasFactory;
    protected $fillable = ['name','client_id','perusahaan_id','tanggal_approve','tanggal_awal','tanggal_akhir','status','nominal','created_by','updated_by'];

    protected $table = 'permintaan_jasa';
}
