<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // dashboard adalah halaman utama setelah user berhasil login
    public function index(){
        return view('dashboard.index');
    }
}
