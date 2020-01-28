<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buku_model;
use Validator;
use Auth;


class BukuController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        
        $validator=Validator::make($req->all(),
            [
                'judul'=>'required',
                'penerbit'=>'required',
                'pengarang'=>'required',
                'foto'=>'required'
            ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $simpan=Buku_model::create([
                'judul'=>$req->judul,
                'penerbit'=>$req->penerbit,
                'pengarang'=>$req->pengarang,
                'foto'=>$req->foto
        ]);
        
            return Response()->json(['status'=>'berhasil']);
        } else {
            return Response()->json(['status'=>'gagal']);
        }
    }

    public function update($id,Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'judul'=>'required',
            'penerbit'=>'required',
            'pengarang'=>'required',
            'foto'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Buku_model::where('id',$id)->update ([
                'judul'=>$req->judul,
                'penerbit'=>$req->penerbit,
                'pengarang'=>$req->pengarang,
                'foto'=>$req->foto
        ]);
            return Response()->json(['status'=>'berhasil']);
        } else {
            return Response()->json(['status'=>'gagal']);
        }
    }
    public function destroy($id)
    {
        if(Auth::user()->level=="admin"){

        $hapus=Buku_model::where('id',$id)->delete();
       
            return Response()->json(['status'=>'berhasil']);
        } else {
            return Response()->json(['status'=>'gagal']);
        }
    }

        public function tampil()

        {
            if(Auth::user()->level=="admin"){
                $dt_buku=Buku_model::get();
                return response()->json($dt_buku);
            }else{
                return response()->json(['status'=>'anda bukan admin']);

            }
        }
   
}
