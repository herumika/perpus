<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Kategori;

use Yajra\Datatables\Facades\Datatables;
use Session;
use DB;

class Kategori_controller extends Controller
{
    public function index()
    {
        $title = 'Daftar Kategori ';

        return view('user.kategori.kategori_index', compact('title'));
    }

    public function store(Request $request)
    {
        $nama = $request->nama;

        $kategori = new Kategori;
        $kategori->nama = $nama;
        $kategori->save();

        Session::flash('pesan', 'Kategori berhasil ditambahkan');

        return redirect('user/kategori');
    }

    public function update(Request $request, $kategori_id)
    {
        $nama = $request->nama_edit;

        \DB::table('kategori')->where('kategori_id', $kategori_id)->update([
            'nama'=>$nama
        ]);

        Session::flash('pesan', 'Kategori berhasil diubah');

        return redirect('user/kategori');
    }

    public function delete($kategori_id)
    {
        \DB::table('kategori')->where('kategori_id', $kategori_id)->delete();

        Session::flash('pesan', 'Kategori berhasil dihapus');

        return redirect('user/kategori');
    }

    public function yajra(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $kategori = Kategori::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'kategori_id',
            'nama'
            ]);

        $datatables = Datatables::of($kategori)->addColumn('action', function ($kategori) {
            return '<a href="#edit-'.$kategori->kategori_id.'" kategori-id="'.$kategori->kategori_id.'" nama="'.$kategori->nama.'" class="btn btn-xs btn-primary btn-edit"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.

            '<a href="#hapus-'.$kategori->kategori_id.'" kategori-id="'.$kategori->kategori_id.'" class="btn btn-xs btn-danger btn-hapus"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }
        
        return $datatables->make(true);
    }
}
