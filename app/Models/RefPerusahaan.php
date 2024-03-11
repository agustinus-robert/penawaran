<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPerusahaan extends Model
{
    use HasFactory;
    protected $fillable = ['nama','alamat','bank','email','created_by','updated_by'];

    protected $table = 'ref_perusahaan';
}
