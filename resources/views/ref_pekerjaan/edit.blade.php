@extends('layouts.app')

@section('konten')
<main>
<div class="container-fluid px-4">
    <h1 class="mt-4">{{__('pekerjaan.judul')}}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">{{__('pekerjaan.judul')}}</li>
    </ol>

    <div class="card shadow mb-12">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 p-2">
                <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i> {{__('pekerjaan.form_edit')}}</h6>
                </div>
            </div>
        </div>
    <form action="{{url('ref_pekerjaan')}}/{{$id}}" method="POST" enctype="multipart/form-data">
        <div class="card-body">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group">
                            <label>{{__('pekerjaan.form_nama')}}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $md->nama) }}" />

                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    

                    <div class="card-footer">
                        <input type="submit" class="btn btn-warning" value="{{__('pekerjaan.form_submit')}}">
                    </div>
                </div>
                </form>
            </div>
        </div>
    </main>
@endsection
