<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Gambar_buku;

use Yajra\Datatables\Facades\Datatables;
use Session;
use DB;

class Buku_controller extends Controller
{
    public function index()
    {
        $title = 'List Buku ';
        $kategoris = Kategori::orderBy('nama', 'asc')->get();

        return view('user.buku.buku_index', compact('title','kategoris'));
    }

    public function store(Request $request)
    {
        $judul = $request->judul;
        $penulis = $request->penulis;
        $kategori_id = $request->kategori_id;
        $tahun = $request->tahun;
        $keterangan = $request->keterangan;

        $buku = new Buku;
        $buku->judul = $judul;
        $buku->kategori_id = $kategori_id;
        $buku->penulis = $penulis;
        $buku->tahun = $tahun;
        $buku->keterangan = $keterangan;
        $buku->save();

        $file = $request->file('image');
        if($file == null)
        {
            
        }else{

            $nama_gambar = $file->getClientOriginalName();
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());

            Gambar_buku::insert( [
                'nama'=>  $nama_gambar,
                'buku_id' =>$buku->buku_id,
                //you can put other insertion here
            ]);
        }

        // $images=array();
        // if($files=$request->file('photo')){
        //     foreach($files as $file){
        //         $name=$file->getClientOriginalName();
        //         $file->move('image',$name);
        //         $images[]=$name;
        //     }
        // }
        // /*Insert your data*/

        // foreach ($images as $image) {
        //     Gambar_buku::insert( [
        //         'nama'=>  $image,
        //         'buku_id' =>$buku->buku_id,
        //         //you can put other insertion here
        //     ]);
        // }

        Session::flash('pesan', 'Buku berhasil ditambahkan');

        return redirect('user/buku');
    }

    public function edit($buku_id)
    {
        $title = 'Edit Buku';
        $buku_id = $buku_id;
        $buku = Buku::where('buku_id',$buku_id)->first();
        $kategoris = Kategori::orderBy('nama', 'asc')->get();

        return view('user.buku.buku_edit', compact('title','buku_id','buku','kategoris'));
    }

    public function update(Request $request, $buku_id)
    {
        $buku = Buku::where('buku_id',$buku_id)->first();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->kategori_id = $request->kategori_id;
        $buku->tahun = $request->tahun;
        $buku->keterangan = $request->keterangan;
        $buku->save();

        $file = $request->file('image');
        if($file == null)
        {
            
        }else{
            \DB::table('gambar_buku')->where('buku_id',$buku_id)->delete();

            $nama_gambar = $file->getClientOriginalName();
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());

            Gambar_buku::insert( [
                'nama'=>  $nama_gambar,
                'buku_id' =>$buku->buku_id,
                //you can put other insertion here
            ]);
        }

        Session::flash('pesan', 'Buku berhasil diubah');

        return redirect('user/buku');
    }

    public function delete($buku_id)
    {
        \DB::table('buku')->where('buku_id', $buku_id)->delete();
        \DB::table('gambar_buku')->where('buku_id',$buku_id)->delete();

        Session::flash('pesan', 'Buku berhasil dihapus');

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
        DB::statement(DB::raw('set @rownum=0'));
        $buku = Buku::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'judul',
            'penulis',
            'tahun',
            'buku_id',
            'kategori_id'
        ]);

        $datatables = Datatables::of($buku)->addColumn('action', function ($buku) {
            return '<a href="'.url('user/pinjam/store/'.$buku->buku_id).'" buku-id="'.$buku->buku_id.'" judul="'.$buku->judul.'" class="btn btn-xs btn-primary btn-pinjaman"><i class="glyphicon glyphicon-edit"></i> Pinjam Buku</a>';
        })->addColumn('penulis', function ($buku) {
            return $buku->penulis;
        })->addColumn('kategori', function ($buku) {
            return $buku->kategori['nama'];
        })->addColumn('keterangan', function ($buku) {
            return $buku->keterangan;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }
        
        return $datatables->make(true);
    }
}
