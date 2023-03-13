<?php

namespace App\Http\Controllers\Auth;

use DB;
use Auth;
use App\Models\Evento;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            if(Auth::user()->fl_active == 'N'){

                Auth::logout();
                Session::flush();
                Flash::warning("Conta inativa, não é possível acessar o sistema");
                return redirect(url('login'))->withInput();

            }else{

                $evento = (Evento::where('fl_corrente_eef',true)->first()) ?: Evento::find(Evento::max('cd_evento_eef'));

                if($evento and empty(\Session::get('evento_id'))){
                    \Session::put('evento_id', $evento->cd_evento_eef);
                    \Session::put('evento_cod', $evento->cd_evento_eve);
                    \Session::put('evento_nome', $evento->nm_evento_eef);
                }

                return redirect()->intended('/');
            }
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
}