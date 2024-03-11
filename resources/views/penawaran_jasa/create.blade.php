@extends('layouts.app')

@section('konten')
<main>

<div class="container-fluid px-4">
    <h1 class="mt-4">{{__('penawaran.judul')}}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">{{__('penawaran.judul')}}</li>
    </ol>

    <div class="card shadow mb-12">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 p-2">
                <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i> {{__('penawaran.form_add')}}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">          
            <form action="<?=url('penawaran_jasa')?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        
                      
                        <div class="form-group">
                            <label>{{__('penawaran.form_pekerjaan')}}</label>
                            <input type="text" class="form-control @error('nama_pekerjaan') is-invalid @enderror" name="nama_pekerjaan" value="{{ old('nama_pekerjaan') }}" />

                            @error('nama_pekerjaan')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{__('penawaran.form_proyek')}}</label>
                            <input type="text" class="form-control @error('nama_proyek') is-invalid @enderror" name="nama_proyek" value="{{ old('nama_proyek') }}" />

                            @error('nama_proyek')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{__('penawaran.table_tipe_pekerjaan')}}</label>
                            <select name="tipe_pekerjaan" id="tipe_pekerjaan" class="form-control @error('tipe_pekerjaan') is-invalid @enderror">
                                <option value="">{{__('penawaran.form_tipe_pekerjaan')}}</option>
                            </select>

                            @error('tipe_pekerjaan')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{__('penawaran.table_client')}}</label>
                            <select name="client" id="client" class="form-control @error('client') is-invalid @enderror">
                                <option value="">{{__('penawaran.form_client')}}</option>
                            </select>

                            @error('client')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{__('penawaran.table_nama_perusahaan')}}</label>
                            <select name="perusahaan" id="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror">
                                <option value="">{{__('penawaran.form_perusahaan')}}</option>
                            </select>

                            @error('perusahaan')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{__('penawaran.form_nominal')}}</label>
                            <input type="number" class="form-control @error('nominal') is-invalid @enderror" name="nominal" value="{{ old('nominal') }}" />

                            @error('nominal')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="{{__('penawaran.form_submit')}}" />
                    </div>
                </form> 
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
 $(document).ready(function() {

        $('#tipe_pekerjaan').select2({
              ajax: {
                url: "{{url('ref_pekerjaan/select')}}",
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
        $("#tipe_pekerjaan").select2("trigger", "select", {data: { id: "{{old('tipe_pekerjaan') ?? ''}}", text: "{{old('tipe_pekerjaan_name') ?? ''}}"} 
        });
        $("#perusahaan").select2("trigger", "select", {data: { id: "{{old('perusahaan') ?? ''}}", text: "{{old('perusahaan_name') ?? ''}}"} 
        });


    });
</script>
@endsection