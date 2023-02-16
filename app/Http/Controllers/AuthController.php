<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        public UserService $userService
    ) {
    }

    public function form()
    {
        return view('auth.form');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if ($username == 'admin' && $password == 'admin') {
            $request->session()->put('username', $username);
            $request->session()->put('role', 'admin');

            return redirect(route('admin'));
        }

        if (
            !is_null($this->userService->getByUsername($username))
            && !is_null($this->userService->getByPassword($password))
        ) {
            $request->session()->put('username', $username);
            $request->session()->put('role', 'user');
            return redirect(route('home'));
        }

        return back()->with('pesan', 'Gagal login');
    }

    public function register(Request $request)
    {
        $nama = $request->input('nama');
        $username = $request->input('username');
        $password = $request->input('password');
        $password2 = $request->input('re-password');

        if(!is_null($this->userService->getByUsername($username))){
            return back()->with([
                'pesan' => 'Gagal register. Username telah tersedia',
                'formLogin' => 'false'
            ]);    
        }

        if($password != $password2){
            return back()->with([
                'pesan' => 'Gagal register. Password dan Konfirmasi Password tidak sesuai',
                'formLogin' => 'false'
            ]); 
        }

        $user = new User();
        $user->fill($request->input());
        $user->password = sha1($password);
        $this->userService->add($user);

        return back()->with([
                'pesan' => 'Sukses register. Silahkan login',
                'formLogin' => 'true'
            ]);  
    }
}
