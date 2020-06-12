<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(){
        if(!session()->get('cliente')){
            return redirect()->route('cliente.login');
        }else{
            dd('opa');
        }
    }
}
