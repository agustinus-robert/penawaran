<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembayaranPembelianModel;
use DB;

class PembayaranPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * 
     * Pembayaran pembelian akan diproses jika pesanan pembelian sudah terdapat nomor referensi, setelah mendapat nomor referensi, maka itu menjadi nota yang berikutnya akan diteruskan pada client, yang dimana client akan membayar nominal sesuai dengan ketetapan di saat penawaran jasa dan permintaan jasa yang sudah disetuji perusahaan yang menjadi target dari client.
     */
    public function index()
    {
        $penawaran_jasa = "SELECT 
        `penawaran_jasa`.`id` as `id`,
        `proyek`.`nama` as `nama`,
        `pesanan_pembelian`.`jasa_id` as `jasa_id`,
        `penawaran_jasa`.`tipe` as `tipe_jasa_id`,
        `penawaran_jasa`.`nominal` as `nominal`,
        `pesanan_pembelian`.`referensi_pembelian` as `referensi_pembelian`,
        `pembayaran_pembelian`.`status` as `status_pembayaran`,
        `pesanan_pembelian`.`id` as `id_pesanan`
        from `penawaran_jasa`
        LEFT JOIN `proyek` ON `proyek`.`id` = `penawaran_jasa`.`proyek_id`
        LEFT JOIN `pesanan_pembelian` ON `pesanan_pembelian`.`jasa_id` = `penawaran_jasa`.`id` AND `pesanan_pembelian`.`tipe_jasa_id` = 1 
        LEFT JOIN `pembayaran_pembelian` ON `pembayaran_pembelian`.`pemesanan_pembelian_id` = `pesanan_pembelian`.`id`
        LEFT JOIN `ref_perusahaan` ON `ref_perusahaan`.`id` = `penawaran_jasa`.`perusahaan_id`
        LEFT JOIN `client` ON `client`.`user_id` = `penawaran_jasa`.`client_id`
        LEFT JOIN `users` ON `users`.`id` = `client`.`user_id`
        WHERE `proyek`.`deleted_at` IS NULL
        AND `penawaran_jasa`.`approve` = '1'
        AND `penawaran_jasa`.`tipe` = '1'
        AND `pesanan_pembelian`.`referensi_pembelian` IS NOT NULL";


        if(\Auth::user()->hasRole('client')){
            $penawaran_jasa .= " AND `penawaran_jasa`.`client_id` = '".\Auth::user()->id."'";
        }

        if(\Auth::user()->hasRole('perusahaan')){
            $penawaran_jasa .= " AND `ref_perusahaan`.`user_id` = '".\Auth::user()->id."'";
        }

        $penawaran_jasa .= " GROUP BY `pesanan_pembelian`.`id`";

        $permintaan_jasa = "SELECT 
        `permintaan_jasa`.`id` as `id`,
        `permintaan_jasa`.`name` as `nama`,
        `pesanan_pembelian`.`jasa_id` as `jasa_id`,
        `permintaan_jasa`.`tipe` as `tipe_jasa_id`,
        `permintaan_jasa`.`nominal` as `nominal`,
        `pesanan_pembelian`.`referensi_pembelian` as `referensi_pembelian`,
        `pembayaran_pembelian`.`status` as `status_pembayaran`,
        `pesanan_pembelian`.`id` as `id_pesanan`
        from `permintaan_jasa`
        LEFT JOIN `pesanan_pembelian` ON `pesanan_pembelian`.`jasa_id` = `permintaan_jasa`.`id` AND `pesanan_pembelian`.`tipe_jasa_id` = 2
        LEFT JOIN `pembayaran_pembelian` ON `pembayaran_pembelian`.`pemesanan_pembelian_id` = `pesanan_pembelian`.`id`
        LEFT JOIN `ref_perusahaan` ON `ref_perusahaan`.`id` = `permintaan_jasa`.`perusahaan_id`
        LEFT JOIN `client` ON `client`.`user_id` = `permintaan_jasa`.`client_id`
        LEFT JOIN `users` ON `users`.`id` = `client`.`user_id`
        WHERE `permintaan_jasa`.`deleted_at` IS NULL 
        AND `permintaan_jasa`.`status` = '1'
        AND `permintaan_jasa`.`tipe` = '2'
        AND `pesanan_pembelian`.`referensi_pembelian` IS NOT NULL";

        if(\Auth::user()->hasRole('client')){
            $permintaan_jasa .= " AND `permintaan_jasa`.`client_id` = '".\Auth::user()->id."'";
        }

        if(\Auth::user()->hasRole('perusahaan')){
            $permintaan_jasa .= " AND `ref_perusahaan`.`user_id` = '".\Auth::user()->id."'";
        }

        $permintaan_jasa .= " GROUP BY `pesanan_pembelian`.`id`";


        $union = $penawaran_jasa.' UNION '.$permintaan_jasa;

        $query = DB::select($union);

        if (request()->ajax()) {
            return datatables()->of($query)
                             ->addIndexColumn()
                             ->addColumn('no_referensi', function ($row) {
                                $template = ''; 
                                $template .= $row->referensi_pembelian;
                                

                                 return $template;
                             })
                             ->addColumn('pembayaran', function($row){
                                $template = '';

                                if(\Auth::user()->hasRole('client') or \Auth::user()->hasRole('admin')){
                                     if(empty($row->status_pembayaran)){
                                     $template .= view('layouts_master.component.button_input_paid', array('id' => $row->id_pesanan, 'nominal' => $row->nominal))->render();
                                    } else {
                                        $template .= '<span class="badge badge-success">'.__('pembelian.aksi_sukses_bayar').'</label>';
                                    }
                                } else {
                                    if($row->status_pembayaran == 1){
                                        $template .= '<span class="badge badge-success">'.__('pembelian.aksi_sukses_bayar').'</label>';
                                    } else {
                                        $template .= '<span class="badge badge-warning">'.__('pembelian.aksi_tunggu_bayar').'</label>';
                                    }
                                }

                                return $template;
                             })
                             ->rawColumns(['no_referensi', 'pembayaran'])
                             ->addIndexColumn()
                             ->make(true);
        }

        return view('pembayaran_pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Pada fungsi create berguna untuk membayar berdasarkan id pesanan yang sudah terdapat nomor referensi, data yang ditampilkan adalah id pemesanan dan nominal pembayaran dari penawaran atau permintaan yang sudah disepakati
     */
    public function create(Request $request)
    {
        //
        $data['id_pesanan_pembelian'] = $request->id;
        $data['nominal_bayar'] = $request->nominal;
        return view('pembayaran_pembelian.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Simpan data pembayaran sesuai dengan nominal, jika pembayaran tidak sesuai nominal maka akan muncul peringatan bahwa nominal yang dibayarkan tidak sama dengan jumlah total bayar berdasarkan pesanan.
     */
    public function store(Request $request)
    {
        //
        $bayarpembelian = new PembayaranPembelianModel();
        
        $bayarpembelian->nominal = $request->bayar_beli;
        $bayarpembelian->pemesanan_pembelian_id = $request->id;
        $bayarpembelian->status = 1;
        $bayarpembelian->created_by = \Auth::user()->id;
        $bayarpembelian->updated_by = \Auth::user()->id;

        if($bayarpembelian->save()){
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'fail']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
