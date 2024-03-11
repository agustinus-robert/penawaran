@extends('layouts.app')

@section('konten')
<main>
<div class="container-fluid px-4">
    <h1 class="mt-4">Menu</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">Profil Anda</li>
    </ol>

    @if (Session::has('msg'))
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1500)" x-show="show">
        <div class="alert alert-success">
            {{ Session::get('msg') }}
        </div>
    </div>
    @endif

    @if (Session::has('msg-server'))
        <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1500)" x-show="show">
            <div class="alert alert-danger">
                {{ Session::get('msg') }}
            </div>
        </div>
    @endif

    <div class="text-right p-2">
        <?php $ed = 'ref_perusahaan/'.Auth::id().'/'.'edit'; ?>
        <a href="<?=url($ed)?>" class="btn btn-warning">Edit</a>
    </div>

    <div class="card shadow mb-12">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 p-2">
                <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i>Profil Anda</h6>
                </div>
            </div>
        </div>
    
        <div class="card-body">
                       <table class="table">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><?=$company->nama?></td>
                            </tr>

                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><?=$company->alamat?></td>
                            </tr>

                            <tr>
                                <td>Bank</td>
                                <td>:</td>
                                <td><?=$company->bank?></td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><?=$company->email?></td>
                            </tr>
                       </table>                    

                    <div class="card-footer">
                       <p>User dibuat pada: <?=$company->created_at?></p>
                    </div>
                </div>
                
            </div>
        </div>
    </main>
@endsection
