<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranModel extends Model
{
    use HasFactory;
    protected $fillable = ['perusahaan_id','client_id','proyek_id','tipe_pekerjaan_id','nominal','approve','created_by','updated_by'];

    protected $table = 'penawaran_jasa';
}
