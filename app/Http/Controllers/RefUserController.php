<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClientModel;
use App\Models\RefPerusahaan;
use Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RefUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Controller user adalah controller untuk mendaftarkan client dan perusahaan, disetiap user akan memiliki role masing-masing sesuai dengan yang ditetapkan oleh admin, setelah user dan role diisi maka pengguna dapat login menggunakan aplikasi ini.
     * 
     * Untuk akses admin bisa melakukan semua transaksi maunpun melakukan permintaan dan penawaran namun ada satu menu profil yang tidak dapat diakses
     * 
     * Untuk akses user menu yang dapat diakses adalah profil client, penawaran, permintaan, dan pembayaran pesanan yang nantinya sudah diberikan nomor referensi oleh role perusahaan
     * 
     * 
     * Untuk akses perusahaan menu yang dapat diakses adalah profil perusahaan, approve penawaran, approve permintaan, kemudian memasukan pesanan pembelian dan bisa juga mengakses pembayaran pembelian.
     */
    public function index()
    {
        // 
        if (request()->ajax()) {
            return datatables()->of(User::select('*')->where('deleted_at', null)->get())
                             ->addIndexColumn()
                             ->addColumn('role', function($row){
                                $template = '';
                                $users = User::findOrFail($row->id);

                                return $users->getRoleNames()->first();
                             })
                             ->addColumn('action', function ($row) {
                                $template = '';
                                 
                                $template .= view('layouts_master.component.button_edit', array('id' => $row->id, 'update' => 'ref_user/'.$row->id.'/edit'))->render();
                                 
                                 $template .= view('layouts_master.component.button_delete', array('id' => $row->id, 'delete' => 'ref_user/'.$row->id))->render();
                                 return $template;
                             })
                             ->rawColumns(['action'])
                             ->addIndexColumn()
                             ->make(true);
        }

        return view('ref_user.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Pada fungsi ini admin akan dihadapkan form seperti email (sebagai username login), nama adalah nama pengguna, password dan konfiramsi password, dan terakhir role untuk memberi akses pengguna.
     */
    public function create()
    {
        //
        return view('ref_user.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Disaat mendaftarkan pengguna harus sesuai ketentuan form, jika tidak akan mengembalikan nilai validasi yang harus diisi.
     */
    public function store(Request $request)
    {
        //

        $rules = array(
            'name'   => 'required',
            'email' => 'required|email|string',
            'password' => 'required|min:8',
            'confirmation_password' => 'required|same:password',
            'role' => 'required'
        );

        $customMessages = [
          'name.required' => __('user.form_validation_name_required'),
          'email.required' => __('user.form_validation_email_required'),
          'email.email' => __('user.form_validation_email_email'),
          'email.string' => __('user.form_validation_email_string'),
          'password.min' => __('user.form_validation_password_min'),
          'password.required' => __('user.form_validation_password_required'),
          'confirmation_password.required' => __('user.form_validation_confirmation_password_required'),
          'confirmation_password.same' => __('user.form_validation_confirmation_password_same'),
          'role.required' => __('user.form_validation_role_required')
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

         if ($validator->fails()) {
            return Redirect::to('ref_user/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $user = new User;
            

            
            $user->name       = $request->input('name');
            $user->email    = $request->input('email');
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->password    = bcrypt($request->input('password'));
            $user->created_by = \Auth::user()->id;
            $user->updated_by = \Auth::user()->id;
            $user->save();

            if($request->role == 1){
                $user->assignRole('admin');
            } else if($request->role == 2){
                $user->assignRole('client');
                $client = new ClientModel;
                $client->user_id = $user->id;
                $client->nama = $request->input('name');
                $client->email = $request->input('email');
                $client->created_by = \Auth::user()->id;
                $client->updated_by = \Auth::user()->id;
                $client->save();
            } else if($request->role == 3){
                $user->assignRole('perusahaan');
                $perusahaan = new RefPerusahaan;
                $perusahaan->user_id = $user->id;
                $perusahaan->nama = $request->input('name');
                $perusahaan->email = $request->input('email');
                $perusahaan->created_by = \Auth::user()->id;
                $perusahaan->updated_by = \Auth::user()->id;
                $perusahaan->save();
            }

            // redirect
            $request->session()->flash('msg', __('user.form_success_add'));
            return Redirect::to('ref_user');
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
     * Kita masih dapat mengedit data pengguna
     */
    public function edit(string $id)
    {
        //
        $md = User::find($id);

        $users = User::findOrFail($id);

        $rl = '';
        if($users->getRoleNames()->first() == 'admin'){
            $rl = 1;
        } else if($users->getRoleNames()->first() == 'client'){
            $rl = 2;
        } else if($users->getRoleNames()->first() == 'perusahaan'){
            $rl = 3;
        }

        return view('ref_user.edit', ['md' => $md, 'id' => $id, 'role' => $rl]);       
    }

    /**
     * Update the specified resource in storage.
     * 
     * Edit harus sesuai dengan validasi
     */
    public function update(Request $request, string $id)
    {
        //
        $rules = array(
            'name'   => 'required',
            'email' => 'required|email|string',
            'password' => 'nullable|min:8',
            'confirmation_password' => 'nullable|same:password|min:8',
            'role' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

         if ($validator->fails()) {
            return Redirect::to('ref_user/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $user = User::find($id);
            

            
            $user->name       = $request->input('name');
            $user->email    = $request->input('email');
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->password    = bcrypt($request->input('password'));
            $user->updated_by = \Auth::user()->id;
            $user->save();

            if($request->role == 1){
                $user->assignRole('admin');
            } else if($request->role == 2){
                $user->assignRole('client');
                
                $client['nama'] = $request->input('name');
                $client['email'] = $request->input('email');
                $client['updated_by'] = \Auth::user()->id;
                
                ClientModel::where('user_id', $id)->update($client);
            } else if($request->role == 3){
                $user->assignRole('perusahaan');
                
                $perusahaan['nama'] = $request->input('name');
                $perusahaan['email'] = $request->input('email');
                $perusahaan['updated_by'] = \Auth::user()->id;
                
                RefPerusahaan::where('user_id', $id)->update($perusahaan);
            }

            // redirect
            $request->session()->flash('msg', __('user.form_success_edit'));
            return Redirect::to('ref_user');
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * 
     * Admin bisa menghapus pengguna
     */
    public function destroy(string $id, Request $request)
    {
        //
        $role = User::where('id', $id)->with('roles')->first();
        
        $update['deleted_at'] = date('Y-m-d H:i:s');
        $update['deleted_by'] = \Auth::user()->id;

        $user = User::whereId($id)->update($update);
        
        if($role->roles->first()->name == 'client'){
            ClientModel::where(['user_id' => $id])->update($update);
        } else if($role->roles->first()->name == 'perusahaan'){
            RefPerusahaan::where(['user_id' => $id])->update($update);
        }
        // redirect
        $request->session()->flash('msg', __('user.form_success_delete'));
        return Redirect::to('ref_user');
    }

    /**
     * Custom function
     * 
     * 
     * Setiap data client diakses dengan cara pemanggilan fungsi select yang dimunculkan sebagai dropdown
     * 
     * 
     * Jika anda login sebagai admin, maka semua data client akan dimunculkan dan dapat digunakan untuk permintaan dan penawaran
     * 
     * Jika anda login sebagai client, maka data client yang akan melakukan penawran atau permintaan adalah data anda sendiri sebagai client yang login. 
     */


    public function select(Request $request){
        if(\Auth::user()->hasRole('admin')){
            return User::where('deleted_at', null)->whereHas('roles', function ($query) {
                 $query->where('roles.id', 2);
            })->with('roles')->get()->toArray();
        } else {
            return User::where(['deleted_at' => null])->whereHas('roles', function ($query) {
                 $query->where(['roles.id' => 2, 'id' => \Auth::user()->id]);
            })->with('roles')->get()->toArray();
        }
    }
}
