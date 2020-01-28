<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggota_model;
use Validator;
use Auth;


class AnggotaController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
            [
                'nama_anggota'=>'required',
                'alamat'=>'required',
                'tlp'=>'required'
            ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $simpan=Anggota_model::create([
                'nama_anggota'=>$req->nama_anggota,
                'alamat'=>$req->alamat,
                'tlp'=>$req->tlp
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }

    public function update($id,Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
                'nama_anggota'=>'required',
                'alamat'=>'required',
                'tlp'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Anggota_model::where('id',$id)->update ([
            'nama_anggota'=>$req->nama_anggota,
            'alamat'=>$req->alamat,
            'tlp'=>$req->tlp
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }
    public function destroy($id)
    {   
        if(Auth::user()->level=="admin"){
        $hapus=Anggota_model::where('id',$id)->delete();
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }

    public function tampil()

    {
        if(Auth::user()->level=="admin"){
            $dt_anggota=Anggota_model::get();
            return response()->json($dt_anggota);
        }else{
            return response()->json(['status'=>'anda bukan admin']);

        }
    }

}
