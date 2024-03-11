<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientModel;
use Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class RefClientController extends Controller
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
     * Pada controller ini client akan bisa mengedit data diri, atau profil dari client, untuk pendaftaran client sendiri didaftarkan oleh role admin, jika admin sudah mendaftarkan client maka setiap role berisi client adapat mengakses data dirinya/profil client.
     */
    public function show(string $id)
    {
        //
        $show = ClientModel::firstWhere('user_id', $id);
        return view('ref_client.show', ['client' => $show]);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * Kita bisa mengedit client kecuali email, untuk email ditutup karena ini menjadi username di saat login
     */
    public function edit(string $id)
    {
        //
        $md = ClientModel::firstWhere('user_id', $id);

        return view('ref_client.edit', ['client' => $md, 'id' => $id]); 
    }

    /**
     * Update the specified resource in storage.
     * 
     * 
     * Pada update data kita diharuskan mengisi client sesuai dengan validasi
     */
    public function update(Request $request, string $id)
    {
        //
        $rules = array(
            'name'   => 'required'
        );

        $customMessages = [
          'name.required' => __('profil_client.form_validation_name'),
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

         if ($validator->fails()) {
            return Redirect::to('ref_client/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            
            $client['nama']       = $request->input('name');
            $client['updated_by'] = \Auth::user()->id;

            ClientModel::where('user_id', $id)->update($client);
            

            
            
            
            // redirect
            $request->session()->flash('msg', __('profil_client.edit_form'));
            return Redirect::to('ref_client/'.$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
