<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefPerusahaan;
use Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class RefPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
     * 
     * 
     * Jika role admin sudah mendaftarkan perusahaan, maka setiap user yang memiliki user perusahaan akan dapat mengakses menu profil, dimana nantinya setiap form dapat dikelola oleh user yang memiliki role perusahaan
     */
    public function show(string $id)
    {
        //
        $show = RefPerusahaan::firstWhere('user_id', $id);
        return view('ref_perusahaan.show', ['company' => $show]);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * 
     * Untuk edit data akan disediakan untuk perubahan alamat, nama, dan bank sedangkan email tidak bisa dirubah karena akan berkaitan langsung dengan login.
     */
    public function edit(string $id)
    {
        //
        $md = RefPerusahaan::firstWhere('user_id', $id);

        return view('ref_perusahaan.edit', ['company' => $md, 'id' => $id]);       
    }

    /**
     * Update the specified resource in storage.
     * 
     * 
     * Untuk update data harus sesuai dengan validasi yang telah dipasang seperti nama, alamat, dan bank tidak boleh kosong, jika tetap dikosongi maka akan muncul peringatan yang berasal dari validasi.
     */
    public function update(Request $request, string $id)
    {
        //
         $rules = array(
            'name'   => 'required',
            'alamat' => 'required',
            'bank' => 'required',
        );

         $customMessages = [
          'name.required' => __('profil_perusahaan.form_validation_name'),
          'alamat.required' => __('profil_perusahaan.form_validation_email'),
          'bank.required' => __('profil_perusahaan.form_validation_alamat'),
        ];


        $validator = Validator::make($request->all(), $rules, $customMessages);

         if ($validator->fails()) {
            return Redirect::to('ref_perusahaan/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            
            $company['nama']       = $request->input('name');
            $company['alamat']    = $request->input('alamat');
            $company['bank']      = $request->input('bank');
            $company['updated_by'] = \Auth::user()->id;

            RefPerusahaan::where('user_id', $id)->update($company);
            

            
            
            
            // redirect
            $request->session()->flash('msg', __('profil_perusahaan.edit_form'));
            return Redirect::to('ref_perusahaan/'.$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // //
        // $update['deleted_at'] = date('Y-m-d H:i:s');
        // $update['deleted_by'] = \Auth::user()->id;

        // $company = RefPerusahaan::whereId($id)->update($update);

        // // redirect
        // $request->session()->flash('message', 'Referensi Perusahan berhasil dihapus');
        // return Redirect::to('ref_perusahaan');
    }

    /**
     * Custom function
     * 
     * 
     * Penambahan custom function pada referensi digunakan untuk memilih nilai dari perusahaan yang ditarget client, untuk melakukan penawaran dan permintaan
     */

    // tambah fungsi custom pada resource controller

    public function select(Request $request){
       return RefPerusahaan::where('nama','like','%'.$request->q.'%')->paginate(5, '*', 'page', $request->page)->toArray();
    }
}
