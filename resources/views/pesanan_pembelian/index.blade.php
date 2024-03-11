@extends('layouts.app')

@section('konten')
<main>
    <div class="container-fluid px-4">
<h1 class="mt-4">{{__('pembelian.judul')}}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
    <li class="breadcrumb-item active">{{__('pembelian.judul')}}</li>
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
                    <th>{{__('pembelian.table_tipe')}}</th>
                    <th>{{__('pembelian.table_referensi')}}</th>
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
        ajax: "{{ url('pesanan_pembelian') }}",
        columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        { data: 'nama', name: 'nama' },
        { data: 'tipe', name: 'tipe', visible: false },
        { data: 'no_referensi', name: 'no_referensi' },
        ],
        order: [[2, 'asc']],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;


            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
              //  console.log(group)
              
                if ( last !== group ) {

                   if(group.indexOf('penawaran') !== -1){
                    $(rows)
                        .eq(i)
                        .before(
                            '<tr class="group"><td colspan="3"><b>'+'<p class="text-primary">'+
                                '<i class="far fa-comments"></i> '+
                                group +
                                '</p></b></td></tr>'
                        );
                    } else {
                        $(rows)
                        .eq(i)
                        .before(
                            '<tr class="group"><td colspan="3"><b>' +'<p class="text-secondary">'+
                                '<i class="far fa-comment"></i> '+
                                group+
                                '</p></b></td></tr>'
                        );
                    }

                    last = group;
                }
            } );
        }, 
        });

        $(document).on('click', '#input_ref', function(){
            $('#modal_show_input_ref').html('')
            var id = $(this).data('id')
            var tipe = $(this).data('tipe')

            $.ajax({
                url: "{{url('pesanan_pembelian/create')}}",
                type: "GET",
                data: {
                    'id' : id,
                    'tipe' : tipe
                }, success: function(response){
                    $('#modal_show_input_ref').html(response)
                  //  datatables.ajax.reload()
                }
            })
        });

        $(document).on('click', '#submit_ref', function(){
            $.ajax({
                url: "{{url('pesanan_pembelian')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : $('#id').val(),
                    'id_tipe' : $('#id_tipe').val(),
                    'ref_beli' : $('#ref_no').val()
                }, success: function(response){
                    var jsons = JSON.parse(response)
                    if(jsons.status == 'success'){
                        
                        datatables.ajax.reload() 
                        $('#refModal').modal('hide');  
                    }
                  //  datatables.ajax.reload()
                }
            })
        })
    });
</script>
@endsection