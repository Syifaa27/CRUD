<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Buku_model;

class master_buku extends Controller{
    public function index()
    {
        if(Auth::user()->level=="admin"){
            $dt_buku=Buku_model::get;
            return response()->json($dt_buku);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
}
