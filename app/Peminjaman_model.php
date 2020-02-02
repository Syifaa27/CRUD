<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman_model extends Model
{
    protected $table="peminjaman";
    protected $primaryKey="id";
    protected $fillable = [
       'tanggal_pinjam', 'id_anggota', 'id_petugas', 'tanggal_deadline', 'denda'
    ];
}
