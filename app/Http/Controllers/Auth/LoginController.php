<?php

namespace App\Http\Controllers\Auth; 
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
 
    protected $redirectTo = RouteServiceProvider::HOME;

      
    protected function authenticated(Request $request, $user)
    {
        if ($user->estado !== 'Ativo') {
            Auth::logout();
            return redirect('/login')->withErrors([
                'email' => 'Utilizador inativo, contate o administrador',
            ]);
        }
    
        return redirect()->route('home');
    }




    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}