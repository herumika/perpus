<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class User_controller extends Controller
{
    public function index()
    {
        $title = 'Dahsboard User';
        $user_id = Auth::user()->id;

        $buku = \DB::table('buku')->get();
        $buku = count($buku);

        $kategori = \DB::table('kategori')->get();
        $kategori = count($kategori);

        $users = \DB::table('users')->where('status',2)->get();
        $users = count($users);

        $pinjaman = \DB::table('pinjaman')->where('user_id',$user_id)->where('status','Belum Dikembalikan')->get();
        $pinjaman = count($pinjaman);

        return view('user.user_index', compact('title','buku','kategori','users','pinjaman'));
    }
}
