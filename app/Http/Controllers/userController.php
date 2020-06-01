<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Support\Facades\Session;

class userController extends Controller
{
    public function showdatauser(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                try{
                    $dataset = DB::table('user')
                    ->select('id_user','username','role')
                    ->get();
                    return view('admin.data-user',['dataset'=>$dataset]);
                }
                catch(\Exception $e){
                    return redirect('showdashboard')->with('error','Kesalahan Sistem');
                }
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function hapusUser($id){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                try{
                    DB::table('user')->where('id_user',$id)->delete();
                    return redirect()->route('datauser')->with('Success','Berhasil Dihapus');
                }
                catch(\Exception $e){
                    return redirect('showdashboard')->with('error','Kesalahan Sistem');
                }
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function resetPass($id){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                try{
                    $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890!$%&?#');
                    $password = substr($random, 0, 7);

                    $pass = md5($password);
            
                    DB::table('user')->where('id_user', $id)->update([
                        'password'=>$pass
                    ]);
                    return redirect()->route('datauser')->with('pass','Password anda = '.$password);
                }
                catch(\Exception $e){
                    return redirect('showdashboard')->with('error','Kesalahan Sistem');
                }
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function tambahUser(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                try{
                    return view('admin.tambah-user');
                }
                catch(\Exception $e){
                    return redirect('showdashboard')->with('error','Kesalahan Sistem');
                }
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function storeUser(Request $request){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                try{
                    $username = $request->get('username');
                    $role = 'user';
                    $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890!$%&?#');
                    $password = substr($random, 0, 7);

                    $pass = md5($password);
            
                    $data = new User([
                        'username'=>$username,
                        'password'=>$pass,
                        'role'=>$role
                    ]);
                    $data->save();
                    return redirect()->route('datauser')->with('pass','Password anda = '.$password);
                }
                catch(\Exception $e){
                    return redirect('showdashboard')->with('error','Kesalahan Sistem');
                }
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }
}
