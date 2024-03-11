<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanJasaModel;
use App\Models\ClientModel;
use App\Models\PekerjaanModel;
use App\Models\ProyekModel;
use Redirect;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PermintaanJasaApproveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sql = "SELECT 
        `ref_perusahaan`.`nama` AS `perusahaan`, 
        `client`.`nama` AS `client`,
        `permintaan_jasa`.`tanggal_awal` AS `tanggal_awal`,
        `permintaan_jasa`.`tanggal_akhir` AS `tanggal_akhir`,
        `permintaan_jasa`.`tanggal_approve` AS `tanggal_approve`,
        `permintaan_jasa`.`name` AS `permintaan`,
        `permintaan_jasa`.`status` AS `approve`,
        `permintaan_jasa`.`nominal` AS `nominal`,
        `permintaan_jasa`.`id` AS `id`
        FROM `permintaan_jasa`
        LEFT JOIN `ref_perusahaan` ON `ref_perusahaan`.`id` = `permintaan_jasa`.`perusahaan_id`
        LEFT JOIN `client` ON `client`.`user_id` = `permintaan_jasa`.`client_id`
        LEFT JOIN `users` ON `users`.`id` = `client`.`user_id`
        WHERE `ref_perusahaan`.`deleted_at` IS NULL 
        AND `users`.`deleted_at` IS NULL
        AND `permintaan_jasa`.`deleted_at` IS NULL
        ";


        if(\Auth::user()->hasRole('perusahaan')){
            $sql .= " AND `ref_perusahaan`.`user_id` = '".\Auth::user()->id."'";
        }


        if (request()->ajax()) {
            return datatables()->of(DB::select($sql))
                             ->addIndexColumn()
                             ->addColumn('approve', function ($row) {
                                $template = '';
                                 
                                //$template .= view('layouts_master.component.button_edit', array('id' => $row->id, 'update' => 'penawaran_jasa/'.$row->id.'/edit'))->render();
                                 if($row->approve == 0){
                                 $template .= view('layouts_master.component.button_approve', array('id' => $row->id, 'approve' => 'approve_permintaan_jasa/'.$row->id))->render();

                                 $template .= view('layouts_master.component.button_not_approve', array('id' => $row->id, 'approve' => 'approve_permintaan_jasa/'.$row->id))->render();
                                } else if($row->approve == 1){
                                    return '<span class="badge badge-success">'.__('permintaan.aksi_setuju').'</span> ('.$row->tanggal_approve.')';
                                } else if($row->approve == 2){
                                    return '<span class="badge badge-success">'.__('permintaan.aksi_ditolak').'</span> ('.$row->tanggal_approve.')';
                                }

                                 return $template;
                             })
                             ->rawColumns(['approve'])
                             ->addIndexColumn()
                             ->make(true);
        }

        return view('approve_permintaan_jasa.index');
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
     */
    public function update(Request $request, string $id)
    {
        //
        $approve_permintaan = PermintaanJasaModel::find($id);
        if($request->approve == 1){
            $approve_permintaan->status = 1;
            $approve_permintaan->tanggal_approve = date('Y-m-d H:i:s');
        } else {
            $approve_permintaan->status = 2;
            $approve_permintaan->tanggal_approve = date('Y-m-d H:i:s');
        }

        $approve_permintaan->save();

        if($request->approve == 1){
            $request->session()->flash('msg', 'Permintaan Telah disetuji');
        } else {
            $request->session()->flash('msg_not', 'Permintaan tidak disetuji');
        }

        return Redirect::to('approve_permintaan_jasa');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
