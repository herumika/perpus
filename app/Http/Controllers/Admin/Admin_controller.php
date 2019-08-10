<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Admin_controller extends Controller
{
    public function index()
    {
        $title = 'Dahsboard Admin';

        $buku = \DB::table('buku')->get();
        $buku = count($buku);

        $kategori = \DB::table('kategori')->get();
        $kategori = count($kategori);

        $users = \DB::table('users')->where('status',2)->get();
        $users = count($users);

        $pinjaman = \DB::table('pinjaman')->where('status','Belum Dikembalikan')->get();
        $pinjaman = count($pinjaman);

        return view('admin.admin_index', compact('title','buku','kategori','users','pinjaman'));
    }
}
