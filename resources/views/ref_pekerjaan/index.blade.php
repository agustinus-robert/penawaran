@extends('layouts.app')

@section('konten')
<main>
    <div class="container-fluid px-4">
<h1 class="mt-4">{{__('pekerjaan.judul')}}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
    <li class="breadcrumb-item active">{{__('pekerjaan.judul')}}</li>
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
    <a href="<?=url('ref_pekerjaan/create')?>" class="btn btn-primary">{{__('pekerjaan.button_tambah')}}</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12 p-2">
            <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i> {{__('pekerjaan.judul_card')}}</h6>
            </div>
        </div>
    </div>
    <div class="card-body">          
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>{{__('pekerjaan.table_no')}}</th>
                    <th>{{__('pekerjaan.table_nama')}}</th>
                    <th>{{__('pekerjaan.table_action')}}</th>
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
        ajax: "{{ url('ref_pekerjaan') }}",
        columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        { data: 'nama', name: 'nama' },
        {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']]
        });
    });
</script>
@endsection