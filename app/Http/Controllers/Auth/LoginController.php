<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
{
    $user = User::whereEmail($request->email)->first();

    $data = [];

    if(!$user){
        $data['email'] = "Sorry Invalid/Unregistered Email!!";
    } 

    if(!empty($user->deleted_at)){
        $data['email'] = "Sorry email was deleted";
    } 

    $data['password'] = 'Wrong Password';


    throw ValidationException::withMessages($data);
    }

    protected function credentials(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        
        if($user){
            if($user->hasRole('admin') == false){
                return array_merge($request->only($this->username(), 'password'), ['deleted_at' => null]);
            } else {
                return array_merge($request->only($this->username(), 'password'), ['deleted_at' => null]);
            }
        } else {
            return array_merge($request->only($this->username(), 'password'), ['deleted_at' => null]);
        }
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->hasRole('admin')) {
            return redirect('dashboard');
        } else if($user->hasRole('perusahaan')){
            return redirect('dashboard');
        } else if($user->hasRole('client')){
            return redirect('dashboard');
        }


        return redirect()->route('login');
    }

    protected function loggedOut(Request $request) {
       return redirect('/login');
    }
}
