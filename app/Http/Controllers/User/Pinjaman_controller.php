<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Pinjaman;
use App\Models\Buku;

use Auth;
use Session;
use DB;

use Yajra\Datatables\Facades\Datatables;

class Pinjaman_controller extends Controller
{
    public function index()
    {
        $title = 'Daftar Buku Yang saya pinjam ';

        return view('user.pinjaman.pinjaman_index',compact('title'));
    }

    public function store($buku_id)
    {
        $user_id = Auth::user()->id;
        $tanggal_pinjam = date("Y-m-d");
        $tanggal_kembali = date("Y-m-d", strtotime("$tanggal_pinjam +7 day"));

        $pinjaman = new Pinjaman;
        $pinjaman->buku_id = $buku_id;
        $pinjaman->user_id = $user_id;
        $pinjaman->tanggal_pinjam = $tanggal_pinjam;
        $pinjaman->tanggal_kembali = $tanggal_kembali;
        $pinjaman->save();

        Session::flash('pesan', 'Buku Berhasil Dipinjam');

        return redirect('user/buku');
    }

    public function ajax_detail($buku_id)
    {
        $buku = Buku::where('buku_id',$buku_id)->first();
        $gambar = $buku->gambar->nama;
        $keterangan = $buku->keterangan;

        return response()->json([
            'gambar'=>$gambar,
            'keterangan'=>$keterangan
        ]);
    }

    public function yajra(Request $request)
    {
        $user_id = Auth::user()->id;
        DB::statement(DB::raw('set @rownum=0'));
        $buku = Pinjaman::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'pinjaman_id',
            'buku_id',
            'user_id',
            'tanggal_pinjam',
            'tanggal_kembali',
            'status'
        ]);

        $datatables = Datatables::of($buku)->addColumn('action', function ($buku) {
            return '<a href="'.url('user/pinjam/store/'.$buku->buku_id).'" buku-id="'.$buku->buku_id.'" judul="'.$buku->judul.'" class="btn btn-xs btn-primary btn-pinjaman"><i class="glyphicon glyphicon-edit"></i> Pinjam Buku</a>';
        })->addColumn('judul', function ($buku) {
            return $buku->buku->judul;
        })->where('user_id',$user_id)->orderBy('tanggal_pinjam','desc');

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }
        
        return $datatables->make(true);
    }
}
