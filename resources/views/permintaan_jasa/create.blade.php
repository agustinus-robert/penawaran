@extends('layouts.app')

@section('konten')
<main>

<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('permintaan.judul') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ __('permintaan.judul') }}</li>
    </ol>

    <div class="card shadow mb-12">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 p-2">
                <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i> {{ __('permintaan.form_add')}}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">          
            <form action="<?=url('permintaan_jasa')?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        
                      
                        <div class="form-group">
                            <label>{{ __('permintaan.form_pekerjaan') }}</label>
                            <input type="text" class="form-control @error('nama_pekerjaan') is-invalid @enderror" name="nama_pekerjaan" value="{{ old('nama_pekerjaan') }}" />

                            @error('nama_pekerjaan')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('permintaan.table_client') }}</label>
                            <select name="client" id="client" class="form-control @error('client') is-invalid @enderror">
                                <option value="">{{ __('permintaan.form_client') }}</option>
                            </select>

                            @error('client')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('permintaan.table_perusahaan') }}</label>
                            <select name="perusahaan" id="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror">
                                <option value="">{{ __('permintaan.form_perusahaan') }}</option>
                            </select>

                            @error('perusahaan')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('permintaan.table_request_date') }}</label>
                                    <input type="date" class="form-control @error('tanggal_awal') is-invalid @enderror" name="tanggal_awal" value="{{ old('tanggal_awal') }}" />

                                    @error('tanggal_awal')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('permintaan.table_end_request_date') }}</label>
                                    <input type="date" class="form-control @error('tanggal_akhir') is-invalid @enderror" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" />

                                    @error('tanggal_akhir')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>{{ __('permintaan.form_nominal') }}</label>
                            <input type="text" class="form-control @error('nominal') is-invalid @enderror" name="nominal" value="{{ old('nominal') }}" />

                            @error('nominal')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="{{ __('permintaan.form_submit') }}" />
                    </div>
                </form> 
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
 $(document).ready(function() {

       $('#perusahaan').select2({
              ajax: {
                url: "{{url('ref_perusahaan/select')}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term || '', // search term
                        page: params.page || 1,
                    };
                },
                processResults: function (data, params) {
                  params.page = params.page || 1;
                  return {
                        results: $.map(data.data, function (item) { return {id: item.id, text: item.nama}}),
                        pagination: {
                            more:(params.page * 5) < data.total
                        }
                    }
                },
                cache: true,
              }
        });

        $('#client').select2({
              ajax: {
                url: "{{url('ref_user/select')}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term || '', // search term
                        page: params.page || 1,
                    };
                },
                processResults: function (data, params) {
                  params.page = params.page || 1;

                  return {
                        results: $.map(data, function (item) { return {id: item.id, text: item.name}}),
                        pagination: {
                            more:(params.page * 5) < data.total
                        }
                    }
                },
                cache: true,
              }
        });

        $("#client").select2("trigger", "select", {data: { id: "{{old('client') ?? ''}}", text: "{{old('client_name') ?? ''}}"} 
        });
        $("#perusahaan").select2("trigger", "select", {data: { id: "{{old('perusahaan') ?? ''}}", text: "{{old('perusahaan_name') ?? ''}}"} 
        });

    });
</script>
@endsection