<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request){
        switch($request->session()->get('role')){
            case 'admin':
                return redirect(route('admin'));
                break;
            case 'user':
                return view('index');
                break;
            default:
                return redirect(route('auth.form'));
        }   
    }
}
