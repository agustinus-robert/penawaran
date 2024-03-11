<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenawaranModel;
use App\Models\ClientModel;
use App\Models\PekerjaanModel;
use App\Models\ProyekModel;
use Redirect;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApprovePenawaranController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Untuk fungsi index disini, data yang ditampilkan meliputi perusahaan, client, proyek, tipe pekerjaan, untuk setiap penawaran terdapat nominal, dan persetujuan, jika status sudah disetujui maka penawaran akan masuk ke pemesanan pembelian.
     */
     public function index()
    {
        //
        $sql = "SELECT 
        `ref_perusahaan`.`nama` AS `perusahaan`, 
        `client`.`nama` AS `client`,
        `proyek`.`nama` AS `proyek`,
        `tipe_pekerjaan`.`nama` AS `tipe_pekerjaan`,
        `pekerjaan`.`nama` AS `pekerjaan`,
        `penawaran_jasa`.`nominal` AS `nominal`,
        `penawaran_jasa`.`approve` AS `approve`,
        `penawaran_jasa`.`id` AS `id`
        FROM `penawaran_jasa`
        LEFT JOIN `ref_perusahaan` ON `ref_perusahaan`.`id` = `penawaran_jasa`.`perusahaan_id`
        LEFT JOIN `client` ON `client`.`user_id` = `penawaran_jasa`.`client_id`
        LEFT JOIN `users` ON `users`.`id` = `client`.`user_id`
        LEFT JOIN `tipe_pekerjaan` ON `tipe_pekerjaan`.`id` = `penawaran_jasa`.`tipe_pekerjaan_id`
        LEFT JOIN `pekerjaan` ON `pekerjaan`.`id` = `penawaran_jasa`.`pekerjaan_id`
        LEFT JOIN `proyek` ON `proyek`.`id` = `penawaran_jasa`.`proyek_id`
        WHERE `ref_perusahaan`.`deleted_at` IS NULL 
        AND `users`.`deleted_at` IS NULL
        AND `proyek`.`deleted_at` IS NULL
        AND `tipe_pekerjaan`.`deleted_at` IS NULL
        AND `penawaran_jasa`.`deleted_at` IS NULL
        ";

         if(\Auth::user()->hasRole('perusahaan')){
            $sql .= " AND `users`.`id` = '".\Auth::user()->id."'";
        }

        if (request()->ajax()) {
            return datatables()->of(DB::select($sql))
                             ->addIndexColumn()
                             ->addColumn('approve', function ($row) {
                                $template = '';
                                 
                                //$template .= view('layouts_master.component.button_edit', array('id' => $row->id, 'update' => 'penawaran_jasa/'.$row->id.'/edit'))->render();
                                 if($row->approve == 0){
                                 $template .= view('layouts_master.component.button_approve', array('id' => $row->id, 'approve' => 'approve_penawaran_jasa/'.$row->id))->render();

                                 $template .= view('layouts_master.component.button_not_approve', array('id' => $row->id, 'approve' => 'approve_penawaran_jasa/'.$row->id))->render();
                                } else if($row->approve == 1){
                                    return '<span class="badge badge-success">'.__('penawaran.aksi_setuju').'</span>';
                                } else if($row->approve == 2){
                                    return '<span class="badge badge-success">'.__('permintaan.aksi_ditolak').'</span>';
                                }

                                 return $template;
                             })
                             ->rawColumns(['approve'])
                             ->addIndexColumn()
                             ->make(true);
        }

        return view('approve_penawaran_jasa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     * 
     * Setelah penawaran diputuskan untuk diapprove atau tidak maka akan mengubah status, jika status = 1 maka disetujui, jika tidak maka status = 2
     */
    public function update(Request $request, string $id)
    {
        //
        $approve_penawaran = PenawaranModel::find($id);
        if($request->approve == 1){
            $approve_penawaran->approve = 1;
            $approve_penawaran->approved_at = date('Y-m-d H:i:s');
        } else {
            $approve_penawaran->approve = 2;
            $approve_penawaran->approved_at = date('Y-m-d H:i:s');
        }

        $approve_penawaran->save();

        if($request->approve == 1){
            $request->session()->flash('msg', 'Penawaran Telah disetuji');
        } else {
            $request->session()->flash('msg_not', 'Penawaran tidak disetuji');
        }

        return Redirect::to('approve_penawaran_jasa');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
