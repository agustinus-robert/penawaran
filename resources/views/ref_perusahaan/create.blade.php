@extends('layouts.app')

@section('konten')
<main>

<div class="container-fluid px-4">
    <h1 class="mt-4">Menu</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">Ref Perusahaan</li>
    </ol>

    <div class="card shadow mb-12">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 p-2">
                <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i> Create Perusahaan Data</h6>
                </div>
            </div>
        </div>
        <div class="card-body">          
            <form action="<?=url('ref_perusahaan')?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        
                      
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" />

                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat">{{ old('alamat') }}</textarea>

                            @error('alamat')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>Bank</label>
                            <input type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" value="{{ old('bank') }}" />

                            @error('bank')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" />

                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Save" />
                    </div>
                </form> 
            </div>
        </div>
    </div>
</main>
@endsection