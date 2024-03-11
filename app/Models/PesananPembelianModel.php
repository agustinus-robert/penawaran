<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananPembelianModel extends Model
{
    use HasFactory;
    protected $fillable = ['jasa_id','tipe_jasa_id','referensi_pembelian','created_by','updated_by'];

    protected $table = 'pesanan_pembelian';
}
