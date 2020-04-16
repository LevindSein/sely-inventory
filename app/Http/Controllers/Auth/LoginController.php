<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use Exception;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(){
        return view('admin.login');
    }

    public function logoutUser(){
        Session::flush();
        return redirect('login')->with('success','Logout Berhasil');
    }

    public function storeLogin(Request $request){
        $username = $request->get('username');
        $pass = md5($request->get('password'));

        $user = DB::table('user')
        ->where('nama_user',$username)
        ->first();

        if($user != null && $user->NAMA_USER == $username){
            if($pass == $user->PASSWORD){
                Session::put('username',$user->NAMA_USER);
                Session::put('role',$user->ROLE);
                Session::put('id_user',$user->ID_USER);
                Session::put('login',TRUE);
                if($user->ROLE == "Super Admin"){
                    return redirect()->route('showdashboard')->with('success','Login Berhasil');
                }
                else if($user->ROLE == "admin"){
                    return redirect()->route('tagihanAdmin')->with('success','Login Berhasil');
                }
                else if($user->ROLE == "kasir"){
                    return redirect()->route('lapTagihanKasir')->with('success','Login Berhasil');
                }
                else if($user->ROLE == "manajer"){
                    return redirect()->route('showdashboardmanajer')->with('success','Login Berhasil');
                }
                else if($user->ROLE == "keuangan"){
                    return redirect()->route('showpenerimaanharian')->with('success','Login Berhasil');
                }
                else{
                    return redirect()->route('index')->with('error','Login Gagal Harap Hubungi Super Admin');    
                }
            }
            else{
                return redirect()->route('index')->with('error','Username atau Password Salah, Harap Hubungi Super Admin');
            }
        }
        else{
            return redirect()->route('index')->with('error','Login Gagal Harap Hubungi Super Admin');
        }
    }
}
