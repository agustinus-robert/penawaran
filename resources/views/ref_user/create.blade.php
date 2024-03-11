@extends('layouts.app')

@section('konten')
<main>

<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('user.judul') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ __('user.judul') }}</li>
    </ol>

    <div class="card shadow mb-12">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 p-2">
                <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i> {{ __('user.form_add') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">          
            <form action="<?=url('ref_user')?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        
                      
                        <div class="form-group">
                            <label>{{ __('user.form_nama') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" />

                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('user.form_email') }}</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" />

                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('user.form_password') }}</label>

                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" />

                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>{{ __('user.form_password_confirm') }}</label>

                            <input type="password" class="form-control @error('confirmation_password') is-invalid @enderror" name="confirmation_password" value="{{ old('confirmation_password') }}" />

                            @error('confirmation_password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('user.form_role') }}</label>

                            <select name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">{{ __('user.form_role') }}</option>
                                <option {{ old('role') == '1' ? 'selected' : '' }} value="1">Admin</option>
                                <option {{ old('role') == '2' ? 'selected' : '' }} value="2">Client</option>
                                <option {{ old('role') == '3' ? 'selected' : '' }} value="3">Perusahaan</option>
                            </select>

                            @error('role')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="{{ __('user.form_submit') }}" />
                    </div>
                </form> 
            </div>
        </div>
    </div>
</main>
@endsection