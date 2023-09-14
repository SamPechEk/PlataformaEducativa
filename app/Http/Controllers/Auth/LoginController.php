<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Model\Rol;
use Illuminate\Support\Facades\Auth;


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
   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }*/
    public function formulario(){
        
		return view('login.login');
    }
    public function logout(){
        
        Auth::logout();
        return redirect('/');
    }
    protected function sendFailedLoginResponse(Request $request){
        
       
        $errors=['error' => 'Inicio de sesion incorrecto, porfavor verifique sus datos.'];
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    protected function redirectTo(){
        
        switch (auth()->user()->idrol) {
            case 3:
                return '/alumno';

            break;
            case 2:
                return '/maestro';
                
            break;
            case 1:
                
                return '/institucion';
            break;
        }
        
        
        
    }
    
    
}
