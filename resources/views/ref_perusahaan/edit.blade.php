@extends('layouts.app')

@section('konten')
<main>
<div class="container-fluid px-4">
    <h1 class="mt-4">{{__('profil_perusahaan.judul')}}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">{{__('profil_perusahaan.judul')}}</li>
    </ol>

    <div class="card shadow mb-12">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 p-2">
                <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i> {{__('profil_perusahaan.profil_header')}}</h6>
                </div>
            </div>
        </div>
    <form action="{{url('ref_perusahaan')}}/{{$id}}" method="POST" enctype="multipart/form-data">
        <div class="card-body">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group">
                            <label>{{__('profil_perusahaan.profil_name')}}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $company->nama) }}" />

                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label>{{__('profil_perusahaan.profil_email')}}</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat">{{ old('alamat', $company->alamat) }}</textarea>

                            @error('alamat')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>{{__('profil_perusahaan.profil_bank')}}</label>
                            <input type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" value="{{ old('bank', $company->bank) }}" />

                            @error('bank')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{__('profil_perusahaan.profil_email')}}</label>
                            <input disabled type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $company->email) }}" />

                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    

                    <div class="card-footer">
                        <input type="submit" class="btn btn-warning" value="{{__('profil_perusahaan.form_edit')}}">
                    </div>
                </div>
                </form>
            </div>
        </div>
    </main>
@endsection
