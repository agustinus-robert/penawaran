<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenawaranModel;
use App\Models\ClientModel;
use App\Models\RefPerusahaan;
use App\Models\PekerjaanModel;
use App\Models\RefTipePekerjaan;
use App\Models\ProyekModel;
use App\Models\User;
use DB;
use Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PenawaranJasaController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Penawaran jasa adalah proses dimana client akan menawarkan suatu proyek dimana terdapat field proyek, nama pekerjaan yang berisi apa yang harus dikerjakan, juga terdapat tipe pekerjaan dimana tipe pekerjaan ini bisa diisi pada refrensi tipe pekerjaan, kemudian terdapat perusahaan yang diajukan penawaran oleh client, setelah itu terdapat nominal yang harus dimasukkan client dan bersifat wajib, setelah selesai maka akan ada persetujuan. 
     * 
     * Nilai awal persetujuan adalah pending, jika di sudah diapprove maka akan berubah menjadi disetujui dan jika tidak maka client bisa mengajukan penawaran baru.
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

        if(\Auth::user()->hasRole('client')){
            $sql .= " AND `users`.`id` = '".\Auth::user()->id."'";
        }

        if (request()->ajax()) {
            return datatables()->of(DB::select($sql))
                             ->addIndexColumn()
                             ->addColumn('action', function ($row) {
                                $template = '';
                                 
                                //$template .= view('layouts_master.component.button_edit', array('id' => $row->id, 'update' => 'penawaran_jasa/'.$row->id.'/edit'))->render();
                                

                                if(empty($row->approve)){
                                 $template .= view('layouts_master.component.button_delete', array('id' => $row->id, 'delete' => 'penawaran_jasa/'.$row->id))->render();
                                } else {
                                    $template .= view('layouts_master.component.button_detail', array('id' => $row->id, 'show' => 'penawaran_jasa/'.$row->id))->render();
                                }


                                 return $template;
                             })
                             ->addColumn('approve', function ($row) {
                                $template = '';
                                 
                                //$template .= view('layouts_master.component.button_edit', array('id' => $row->id, 'update' => 'penawaran_jasa/'.$row->id.'/edit'))->render();
                                 
                                if($row->approve == 1){
                                    return '<span class="badge badge-success">'.__('penawaran.aksi_setuju').'</span>';
                                } else if($row->approve == 2){
                                    return '<span class="badge badge-success">'.__('penawaran.aksi_ditolak').'</span>';
                                } else {
                                    return '<span class="badge badge-warning">'.__('penawaran.aksi_menunggu').'</span>';
                                }
                                 return $template;
                                
                             })
                             ->rawColumns(['action', 'approve'])
                             ->addIndexColumn()
                             ->make(true);
        }

        return view('penawaran_jasa.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Disini kita akan dihadapkan form yang harus diisi meliputi nama pekerjaan, nama proyek, tipe pekerjaan, tujuan perusahaan, nominal pengajuan
     */
    public function create()
    {
        //
        //$data['client'] = User::role('client')->get();
        //dd();

        return view('penawaran_jasa.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * 
     * Fungsi store memiliki validasi, jadi semua data seperti pekerjaan, proyek, tipe pekerjaan, client, perusahaan, dan nominal harus diisi, jika dilewatkan dan kemudian di submit maka akan mengembalikan nilai validasi, pastikan semua data diisi.
     */
    public function store(Request $request)
    {
        //
        $rules = array(
            'nama_pekerjaan'  => 'required',
            'nama_proyek' => 'required',
            'tipe_pekerjaan' => 'required',
            'client' => 'required',
            'perusahaan' => 'required',
            'nominal' => 'required',
        );

        $customMessages = [
          'nama_pekerjaan.required' => __('penawaran.form_validation_nama_pekerjaan_required'),
          'nama_proyek.required' => __('penawaran.form_validation_name_proyek_required'),
          'tipe_pekerjaan.required' => __('penawaran.form_validation_tipe_pekerjaan_required'),
          'client.required' => __('penawaran.form_validation_client_required'),
          'perusahaan.required' => __('penawaran.form_validation_perusahaan_required'),
          'nominal.required' => __('penawaran.form_validation_nominal_required')
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if(!empty($request->client)){
            $request->request->add(['client_name' => User::whereId($request->client)->first()->name]);
        }

        if(!empty($request->tipe_pekerjaan)){
            $request->request->add(['tipe_pekerjaan_name' => RefTipePekerjaan::whereId($request->tipe_pekerjaan)->first()->nama]);
        }

        if(!empty($request->perusahaan)){
            $request->request->add(['perusahaan_name' => RefPerusahaan::whereId($request->perusahaan)->first()->nama]);
        }

         if ($validator->fails()) {
            return Redirect::to('penawaran_jasa/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $pekerjaan = new PekerjaanModel;
            $proyek = new ProyekModel;
            $penawaran = new PenawaranModel();
            
            
            $pekerjaan->nama = $request->nama_pekerjaan;
            $pekerjaan->created_by = \Auth::user()->id;
            $pekerjaan->updated_by = \Auth::user()->id;
            $pekerjaan->save();

            $proyek->nama = $request->nama_proyek;
            $proyek->created_by = \Auth::user()->id;
            $proyek->updated_by = \Auth::user()->id;
            $proyek->save();

            $penawaran->tipe = 1;
            $penawaran->pekerjaan_id = $pekerjaan->id;
            $penawaran->perusahaan_id = $request->perusahaan;
            $penawaran->client_id = $request->client;
            $penawaran->proyek_id = $proyek->id;
            $penawaran->tipe_pekerjaan_id = $request->tipe_pekerjaan;
            $penawaran->nominal = $request->nominal;
            $penawaran->approve = 0;
            $penawaran->created_by = \Auth::user()->id;
            $penawaran->updated_by = \Auth::user()->id;

            $penawaran->save();
         
            // redirect
            $request->session()->flash('msg', __('penawaran.form_success_add'));
            return Redirect::to('penawaran_jasa');
        }
    }

    /**
     * Display the specified resource.
     * 
     * 
     * Disini detail dari pengisian dapat kita periksa setelah disetujui/tidak disetujui, di dalam rincian data terdapat nama perusahaan, proyek, nama pekerjaan, tipe pekerjaan, tanggal diajukan, status, dan nominal.
     */
    public function show(string $id)
    {
        //
        $data['core'] = PenawaranModel::whereId($id)->first();


        $data['pekerjaan'] = PekerjaanModel::whereId($data['core']->pekerjaan_id)->first();
        $data['perusahaan'] = User::whereId($data['core']->perusahaan_id)->first();
        $data['pekerjaan_tipe'] = RefTipePekerjaan::whereId($data['core']->tipe_pekerjaan_id)->first();
        $data['client'] = User::whereId($data['core']->client_id)->first();
        $data['proyek'] = ProyekModel::whereId($data['core']->proyek_id)->first();

        return view('penawaran_jasa.show', $data);
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
     * 
     * 
     * Ini adalah soft delete, jadi jika status masih pending maka bisa dihapus, jika sudah disetujui/tidak disetujui maka data tidak bisa dihapus
     */
    public function destroy(string $id, Request $request)
    {
        //

        $update['deleted_at'] = date('Y-m-d H:i:s');
        $update['deleted_by'] = \Auth::user()->id;

        $company = PenawaranModel::whereId($id)->update($update);

        // redirect
        $request->session()->flash('msg', __('penawaran.form_success_delete'));
        return Redirect::to('penawaran_jasa');
    }
}
