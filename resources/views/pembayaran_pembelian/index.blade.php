@extends('layouts.app')

@section('konten')
<main>
    <div class="container-fluid px-4">
<h1 class="mt-4">{{__('pembelian.judul_pembayaran')}}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
    <li class="breadcrumb-item active">{{__('pembelian.judul_pembayaran')}}</li>
</ol>

@if (Session::has('msg'))
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1500)" x-show="show">
        <div class="alert alert-success">
            {{ Session::get('msg') }}
        </div>
    </div>
@endif

@if (Session::has('msg_not'))
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1500)" x-show="show">
        <div class="alert alert-danger">
            {{ Session::get('msg') }}
        </div>
    </div>
@endif


<div class="card shadow mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12 p-2">
            <h6 class="font-weight-bold text-primary"><i class="far fa-comments me-1"></i> {{__('pembelian.judul_card')}}</h6>
            </div>
        </div>
    </div>
    <div class="card-body">          
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>{{__('pembelian.table_no')}}</th>
                    <th>{{__('pembelian.table_nama')}}</th>
                    <th>{{__('pembelian.table_referensi')}}</th>
                    <th>{{__('pembelian.table_status')}}</th>
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
        var datatables = $('#datatablesSimple').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('pembayaran_pembelian') }}",
        columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        { data: 'nama', name: 'nama' },
        { data: 'no_referensi', name: 'no_referensi' },
        { data: 'pembayaran', name: 'pembayaran'}
        ],
        order: [[0, 'asc']]
        });

        $(document).on('click', '#input_paid', function(){
            $('#modal_show_input_paid').html('')
            var id = $(this).data('id')
            var nominal = $(this).data('nominal')
            
            $.ajax({
                url: "{{url('pembayaran_pembelian/create')}}",
                type: "GET",
                data: {
                    'id' : id,
                    'nominal' : nominal
                }, success: function(response){
                    $('#modal_show_input_paid').html(response)
                  //  datatables.ajax.reload()
                }
            })
        });

        $(document).on('click', '#submit_paid', function(){
            if($('#paid').val() == $('#nominal_harus_bayar').val()){
                $.ajax({
                    url: "{{url('pembayaran_pembelian')}}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id' : $('#id').val(),
                        'bayar_beli' : $('#paid').val()
                    }, success: function(response){
                        var jsons = JSON.parse(response)
                        if(jsons.status == 'success'){
                            
                            datatables.ajax.reload() 
                            $('#paidModal').modal('hide');  
                        }
                      //  datatables.ajax.reload()
                    }
                })
            } else {
                alert("{{__('global.paids')}}")
            }
        })
    });
</script>
@endsection