<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanJasaModel;
use App\Models\ClientModel;
use App\Models\PekerjaanModel;
use App\Models\ProyekModel;
use App\Models\User;
use App\Models\RefPerusahaan;
use Redirect;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PermintaanJasaController extends Controller
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
                                 $template .= view('layouts_master.component.button_delete', array('id' => $row->id, 'delete' => 'permintaan_jasa/'.$row->id))->render();
                                } else {
                                    $template .= view('layouts_master.component.button_detail', array('id' => $row->id))->render();
                                }


                                 return $template;
                             })
                             ->addColumn('approve', function ($row) {
                                $template = '';
                                 
                                //$template .= view('layouts_master.component.button_edit', array('id' => $row->id, 'update' => 'penawaran_jasa/'.$row->id.'/edit'))->render();
                                 
                                if($row->approve == 1){
                                    $template .= '<span class="badge badge-success">'.__('permintaan.aksi_setuju').'</span>';
                                } else if($row->approve == 2){
                                    $template .= '<span class="badge badge-success">'.__('permintaan.aksi_ditolak').'</span>';
                                } else {
                                    $template .= '<span class="badge badge-warning">'.__('permintaan.aksi_menunggu').'</span>';
                                }

                                 return $template;
                                
                             })
                             ->rawColumns(['action', 'approve'])
                             ->addIndexColumn()
                             ->make(true);
        }

        return view('permintaan_jasa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('permintaan_jasa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules = array(
            'nama_pekerjaan'  => 'required',
            'perusahaan' => 'required',
            'client' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required|after:tanggal_awal',
            'nominal' => 'required',
        );

        $customMessages = [
          'nama_pekerjaan.required' => __('permintaan.form_validation_nama_request_required'),
          'perusahaan.required' => __('permintaan.form_validation_perusahaan_required'),
          'client.required' => __('permintaan.form_validation_client_required'),
          'tanggal_awal.required' => __('permintaan.form_validation_tglawal_required'),
          'tanggal_akhir.required' => __('permintaan.form_validation_tglakhir_required'),
          'nominal.required' => __('permintaan.form_validation_harga_required'),
          'tanggal_akhir.after' => __('permintaan.form_validation_date_akhir') 
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if(!empty($request->client)){
            $request->request->add(['client_name' => User::whereId($request->client)->first()->name]);
        }

        if(!empty($request->perusahaan)){
            $request->request->add(['perusahaan_name' => RefPerusahaan::whereId($request->perusahaan)->first()->nama]);
        }

         if ($validator->fails()) {
            return Redirect::to('permintaan_jasa/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            
            $permintaan = new PermintaanJasaModel();
            
            $permintaan->name = $request->nama_pekerjaan;
            $permintaan->perusahaan_id = $request->perusahaan;
            $permintaan->client_id = $request->client;
            $permintaan->tanggal_awal = $request->tanggal_awal;
            $permintaan->tanggal_akhir = $request->tanggal_akhir;
            $permintaan->nominal = $request->nominal;
            $permintaan->status = 0;
            $permintaan->tipe = 2;
            $permintaan->created_by = \Auth::user()->id;
            $permintaan->updated_by = \Auth::user()->id;

            $permintaan->save();
         
            // redirect
            $request->session()->flash('msg', __('permintaan.form_success_add'));
            return Redirect::to('permintaan_jasa');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data['core'] = PermintaanJasaModel::whereId($id)->first();
        $data['perusahaan'] = User::whereId($data['core']->perusahaan_id)->first();
        $data['client'] = User::whereId($data['core']->client_id)->first();
       
        return view('permintaan_jasa.show', $data);
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
        $update['deleted_at'] = date('Y-m-d H:i:s');
        $update['deleted_by'] = \Auth::user()->id;

        $company = PermintaanJasaModel::whereId($id)->update($update);

        // redirect
        $request->session()->flash('msg', __('permintaan.form_success_delete'));
        return Redirect::to('permintaan_jasa');    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        //
        $update['deleted_at'] = date('Y-m-d H:i:s');
        $update['deleted_by'] = \Auth::user()->id;

        $company = PermintaanJasaModel::whereId($id)->update($update);

        // redirect
        $request->session()->flash('msg', __('permintaan.form_success_delete'));
        return Redirect::to('permintaan_jasa');
    }
}
