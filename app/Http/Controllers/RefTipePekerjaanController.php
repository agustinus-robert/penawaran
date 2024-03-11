<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefTipePekerjaan;
use Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RefTipePekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Data tipe pekerjaan ini berupa master data, diisikan oleh admin, jadi admin mengisikan tipe sebelum client untuk dapat melakukan penawaran, pastikan admin mengisi tipe pekerjaan dahulu sebelum client melakukan transaksi penawaran atau permintaan
     */
    public function index()
    {
        //
        if (request()->ajax()) {
            return datatables()->of(RefTipePekerjaan::select('*')->where('deleted_at', null)->get())
                             ->addIndexColumn()
                             ->addColumn('action', function ($row) {
                                $template = '';
                                 
                                $template .= view('layouts_master.component.button_edit', array('id' => $row->id, 'update' => 'ref_pekerjaan/'.$row->id.'/edit'))->render();
                                 
                                 $template .= view('layouts_master.component.button_delete', array('id' => $row->id, 'delete' => 'ref_pekerjaan/'.$row->id))->render();
                                 return $template;
                             })
                             ->rawColumns(['action'])
                             ->addIndexColumn()
                             ->make(true);
        }

        return view('ref_pekerjaan.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Disini kita bisa mengisikan nama tipe pekerjaan
     */
    public function create()
    {
        //
        return view('ref_pekerjaan.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Tipe pekerjaan memiliki valdasi nama tidak boleh kosong
     */
    public function store(Request $request)
    {
        //
        $rules = array(
            'name'   => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

         if ($validator->fails()) {
            return Redirect::to('ref_pekerjaan/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $md = new RefTipePekerjaan;
            

            
            $md->nama       = $request->input('name');
            $md->created_by = \Auth::user()->id;
            $md->updated_by = \Auth::user()->id;
            $md->save();

            // redirect
            $request->session()->flash('msg', __('pekerjaan.form_success_add'));
            return Redirect::to('ref_pekerjaan');
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
     * 
     * Kita bisa merubah tipe pekerjaan yang sudah kita masukkan
     */
    public function edit(string $id)
    {
        //
         $md = RefTipePekerjaan::find($id);

        return view('ref_pekerjaan.edit', ['md' => $md, 'id' => $id]); 
    }

    /**
     * Update the specified resource in storage.
     * 
     * Proses update harus sesuai dengan nilai validasi, jika nama tidak diisikan maka akan memiliki nilai kembalian validasi
     */
    public function update(Request $request, string $id)
    {
        //
        $rules = array(
            'name'   => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

         if ($validator->fails()) {
            return Redirect::to('ref_pekerjaan/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        } else {
            $md = RefTipePekerjaan::find($id);
            

            
            $md->nama       = $request->input('name');
            $md->updated_by = \Auth::user()->id;
            $md->save();

            // redirect
            $request->session()->flash('msg', __('pekerjaan.form_success_edit'));
            return Redirect::to('ref_pekerjaan');
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * Soft delete untuk menghapus tipe pekerjaan
     */
    public function destroy(string $id, Request $request)
    {
        //
        $update['deleted_at'] = date('Y-m-d H:i:s');
        $update['deleted_by'] = \Auth::user()->id;

        $company = RefTipePekerjaan::whereId($id)->update($update);

        // redirect
        $request->session()->flash('msg', __('pekerjaan.form_success_delete'));
        return Redirect::to('ref_pekerjaan');
    }

    /**
     * Custom controller
     * 
     * Data tipe pekerjaan diambil dari controller ini yang nantinya akan digunakan untuk transaksi penawran oleh client
     */

    // tambah fungsi custom pada resource controller
    public function select(Request $request){
        return RefTipePekerjaan::where('nama','like','%'.$request->q.'%')->paginate(5, '*', 'page', $request->page)->toArray();
    }
}
