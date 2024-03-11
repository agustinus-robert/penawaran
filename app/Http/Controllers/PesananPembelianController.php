<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananPembelianModel;
use DB;

class PesananPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * 
     * Pesanan pemeblian meliputi data yang sudah diapprove baik dari penawaran atau permintaan, jika data sudah disetujui maka perusahaan dapat mengirimkan nomor referensi/mirip seperti invoice dan nanti dikembalikan pada client menjadi sebuah bukti untuk membayar nominal yang sudah disepakati.
     */
    public function index()
    {
        //
        $penawaran_jasa = "SELECT 
        `penawaran_jasa`.`id` as `id`,
        `proyek`.`nama` as `nama`,
        `pesanan_pembelian`.`jasa_id` as `jasa_id`,
        `penawaran_jasa`.`tipe` as `tipe_jasa_id`,
        `pesanan_pembelian`.`referensi_pembelian` as `referensi_pembelian`
        from `penawaran_jasa`
        LEFT JOIN `proyek` ON `proyek`.`id` = `penawaran_jasa`.`proyek_id`
        LEFT JOIN `pesanan_pembelian` ON `pesanan_pembelian`.`jasa_id` = `penawaran_jasa`.`id` AND `pesanan_pembelian`.`tipe_jasa_id` = 1
        LEFT JOIN `ref_perusahaan` ON `ref_perusahaan`.`id` = `penawaran_jasa`.`perusahaan_id`
        LEFT JOIN `client` ON `client`.`user_id` = `penawaran_jasa`.`client_id`
        LEFT JOIN `users` ON `users`.`id` = `client`.`user_id` 
        WHERE `proyek`.`deleted_at` IS NULL
        AND `penawaran_jasa`.`approve` = '1'
        AND `penawaran_jasa`.`tipe` = '1'";

        if(\Auth::user()->hasRole('perusahaan')){
            $penawaran_jasa .= " AND `ref_perusahaan`.`user_id` = '".\Auth::user()->id."'";
        }

        $penawaran_jasa .= " GROUP BY `penawaran_jasa`.`id`";

        $permintaan_jasa = "SELECT 
        `permintaan_jasa`.`id` as `id`,
        `permintaan_jasa`.`name` as `nama`,
        `pesanan_pembelian`.`jasa_id` as `jasa_id`,
        `permintaan_jasa`.`tipe` as `tipe_jasa_id`,
        `pesanan_pembelian`.`referensi_pembelian` as `referensi_pembelian`
        from `permintaan_jasa`
        LEFT JOIN `pesanan_pembelian` ON `pesanan_pembelian`.`jasa_id` = `permintaan_jasa`.`id` AND `pesanan_pembelian`.`tipe_jasa_id` = 2
        LEFT JOIN `ref_perusahaan` ON `ref_perusahaan`.`id` = `permintaan_jasa`.`perusahaan_id`
        LEFT JOIN `client` ON `client`.`user_id` = `permintaan_jasa`.`client_id`
        LEFT JOIN `users` ON `users`.`id` = `client`.`user_id` 
        WHERE `permintaan_jasa`.`deleted_at` IS NULL 
        AND `permintaan_jasa`.`status` = '1'
        AND `permintaan_jasa`.`tipe` = '2'";
        
        if(\Auth::user()->hasRole('perusahaan')){
            $permintaan_jasa .= " AND `ref_perusahaan`.`user_id` = '".\Auth::user()->id."'";
        }
        
        $permintaan_jasa .= " GROUP BY `permintaan_jasa`.`id` 
        ";


        $union = $penawaran_jasa.' UNION '.$permintaan_jasa;

        $query = DB::select($union);

        if (request()->ajax()) {
            return datatables()->of($query)
                             ->addIndexColumn()
                             ->addColumn('tipe', function($row){
                                if($row->tipe_jasa_id == 1){
                                    return "Penawaran";
                                } else if($row->tipe_jasa_id == 2) {
                                    return "Permintaan";
                                }
                             })
                             ->addColumn('no_referensi', function ($row) {
                                $template = '';
                                 
                                //$template .= view('layouts_master.component.button_edit', array('id' => $row->id, 'update' => 'penawaran_jasa/'.$row->id.'/edit'))->render();
                                 if(empty($row->referensi_pembelian)){
                                 $template .= view('layouts_master.component.input_ref', array('id' => $row->id, 'tipe' => $row->tipe_jasa_id, 'form' => 'pesanan_pembelian/'))->render();
                                } else {
                                    $template .= $row->referensi_pembelian;
                                }

                                 return $template;
                             })
                             ->rawColumns(['no_referensi'])
                             ->addIndexColumn()
                             ->make(true);
        }

        return view('pesanan_pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Disini perusahaan akan mengisi nomor referensi yang akan dijadikan dasar untuk bukti nota/invoice yang nantinya dapat diproses pada pembayaran pembelian.
     */
    public function create(Request $request)
    {
        $data['id'] = $request->input('id');
        $data['tipe'] = $request->input('tipe');

        return view('pesanan_pembelian.create', $data);
        //
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Data yang disimpan adalah data referensi dari transaksi penawaran ataupun pembelian
     */
    public function store(Request $request)
    {
        //
        $pesananpembelian = new PesananPembelianModel();
        
        $pesananpembelian->jasa_id = $request->id;
        $pesananpembelian->tipe_jasa_id = $request->id_tipe;
        $pesananpembelian->referensi_pembelian = $request->ref_beli;
        $pesananpembelian->created_by = \Auth::user()->id;
        $pesananpembelian->updated_by = \Auth::user()->id;

        if($pesananpembelian->save()){
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
