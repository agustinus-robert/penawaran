@extends('layouts.app')

@section('konten')
<main>
    <div class="container-fluid px-4">
<h1 class="mt-4">{{ __('permintaan.judul') }}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ __('permintaan.judul') }}</li>
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
    <a href="<?=url('permintaan_jasa/create')?>" class="btn btn-primary">{{ __('permintaan.button_tambah') }}</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12 p-2">
            <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i> {{ __('permintaan.judul_card') }}</h6>
            </div>
        </div>
    </div>
    <div class="card-body">          
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>{{ __('permintaan.table_no') }}</th>
                    <th>{{ __('permintaan.table_nama_permintaan') }}</th>
                    <th>{{ __('permintaan.table_client') }}</th>
                    <th>{{ __('permintaan.table_perusahaan') }}</th>
                    <th>{{ __('permintaan.table_request_date') }}</th>
                    <th>{{ __('permintaan.table_end_request_date') }}</th>
                    <th>{{ __('permintaan.table_nominal') }}</th>
                    <th>{{ __('permintaan.table_approve') }}</th>
                    <th>{{ __('permintaan.table_action') }}</th>
                </tr>
            </thead>

            <tbody>
            </tbody>
        </table> 
    </div>
</div>
</div>
</main>


<script type="text/javascript">
    $(document).ready( function () {
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $('#datatablesSimple').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('permintaan_jasa') }}",
        columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        { data: 'permintaan', name: 'permintaan' },
        { data: 'client', name: 'client' },
        { data: 'perusahaan', name: 'perusahaan' },
        { data: 'tanggal_awal', name: 'tanggal_awal' },
        { data: 'tanggal_akhir', name: 'tanggal_akhir' },
        { data: 'nominal', name: 'nominal' },
        { data: 'approve', name: 'approve' },
        {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']]
        });
    });


    $(document).on('click', '#detail', function(){
            $('#modal_show').html('')
            var id = $(this).data('id')
            
            $.ajax({
                url: "{{url('permintaan_jasa')}}/"+id,
                type: "GET",
                success: function(response){
                    $('#modal_show').html(response)
                  //  datatables.ajax.reload()
                }
            })
        });
</script>
@endsection