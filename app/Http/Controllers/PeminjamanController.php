<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peminjaman_model;
use App\DetailPeminjaman_model;
use Validator;
use Auth;
use DB;


class PeminjamanController extends Controller
{
    public function insert(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
            [
                'id_pinjam'=>'required',
                'id_buku'=>'required',
                'qty'=>'required'
                
            ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $simpan=DetailPeminjaman_model::create([
                'id_pinjam'=>$req->id_pinjam,
                'id_buku'=>$req->id_buku,
                'qty'=>$req->qty
                
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }

    public function index($id){
        $peminjaman = DB::table('peminjaman')
        ->join('anggota', 'anggota.id', '=', 'peminjaman.id_anggota')
        ->select('peminjaman.id', 'peminjaman.id_anggota', 'anggota.nama_anggota', 'peminjaman.id_petugas',
                 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_deadline', 'denda')
                 ->where('peminjaman.id', $id)
                 ->get();

                 $detail_buku="data";
                 $data=array();
                 foreach ($peminjaman as $pinjam){
                     $ok = DetailPeminjaman_model::where('id_pinjam', $pinjam->id)->get();

                     $arr_detail=array();
                     foreach ($ok as $ok){
                         $arr_detail[]=array(
                             'id_pinjam' => $ok->id_pinjam,
                             'id_buku' => $ok->id_buku,
                             'qty' => $ok->qty
                         );
                     }

                     $data[]=array(
                         'id' => $pinjam->id,
                         'id_anggota' => $pinjam->id_anggota,
                         'nama_anggota' => $pinjam->nama_anggota,
                         'id_petugas' => $pinjam->id_petugas,
                         'tanggal_pinjam' => $pinjam->tanggal_pinjam,
                         'tanggal_deadline' => $pinjam->tanggal_deadline,
                         'denda' => $pinjam->denda,
                         'detail_buku' => $arr_detail
                     );
                 }
                 return response()->json(compact("data"));
                

    }

    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
            [
                'tanggal_pinjam'=>'required',
                'id_anggota'=>'required',
                'id_petugas'=>'required',
                'tanggal_deadline'=>'required',
                'denda'=>'required'
            ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $simpan=Peminjaman_model::create([
                'tanggal_pinjam'=>$req->tanggal_pinjam,
                'id_anggota'=>$req->id_anggota,
                'id_petugas'=>$req->id_petugas,
                'tanggal_deadline'=>$req->tanggal_deadline,
                'denda'=>$req->denda
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
            'tanggal_pinjam'=>'required',
            'id_anggota'=>'required',
            'id_petugas'=>'required',
            'tanggal_deadline'=>'required',
            'denda'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Peminjaman_model::where('id',$id)->update ([
                'tanggal_pinjam'=>$req->tanggal_pinjam,
                'id_anggota'=>$req->id_anggota,
                'id_petugas'=>$req->id_petugas,
                'tanggal_deadline'=>$req->tanggal_deadline,
                'denda'=>$req->denda
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }
    public function destroy($id)
    {   
        if(Auth::user()->level=="admin"){
        $hapus=Peminjaman_model::where('id',$id)->delete();
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }

    public function tampil()

    {
        if(Auth::user()->level=="admin"){
            $dt_anggota=Peminjaman_model::get();
            return response()->json($dt_anggota);
        }else{
            return response()->json(['status'=>'anda bukan admin']);

        }
    }

}
