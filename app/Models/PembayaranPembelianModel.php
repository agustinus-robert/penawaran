<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPembelianModel extends Model
{
    use HasFactory;
    protected $fillable = ['pemesanan_pembelian_id','nominal','status','created_by','updated_by'];

    protected $table = 'pembayaran_pembelian';
}
