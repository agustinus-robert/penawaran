<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekModel extends Model
{
    use HasFactory;
    protected $fillable = ['nama','created_by','updated_by'];

    protected $table = 'proyek';
}
