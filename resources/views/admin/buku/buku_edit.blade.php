@extends('layouts_admin.master')

@section('content')

<link href="https://datatables.yajrabox.com/css/datatables.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

<div class="row">
    <div class="col-md-8 col-md-offset-2">
            <div class="box">
        
                <form action="{{ url('admin/buku/update/'.$buku_id) }}" method="POST" role="form" class="form-tambah" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Judul Buku</label>
                        <input type="text" name="judul" value="{{ $buku->judul }}" class="form-control" id="exampleInputEmail1" placeholder="Nama" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Penulis</label>
                        <input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control" id="exampleInputEmail1" placeholder="Penulis" autofocus>
                    </div>
        
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kategori</label>
                        <select name="kategori_id" class="form-control select2" id="">
                                <option value="" selected disabled>Pilih Kategori</option>
                            @foreach($kategoris as $ks)
                                <option value="{{ $ks->kategori_id }}" {{ ($buku->kategori_id == $ks->kategori_id) ? 'selected' : '' }}>{{ $ks->nama }}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tahun</label>
                        <input type="number" value="{{ $buku->tahun }}" name="tahun" class="form-control" id="exampleInputEmail1" placeholder="Ex: 1995" autocomplete="off" maxlength="4">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Keterangan</label>
                        <textarea name="keterangan" id="" rows="10" class="textarea form-control">{{ $buku->keterangan }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Upload Gambar</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Update Buku</button>
                    </div>
                </form>
        
            </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
<script src="https://datatables.yajrabox.com/js/handlebars.js"></script>
<script src="{{('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

<script>
    $(document).ready(function(){
        $('.textarea').wysihtml5()
    })
</script>

@endsection