@extends('layouts_user.master')

@section('content')

<link href="https://datatables.yajrabox.com/css/datatables.bootstrap.css" rel="stylesheet">

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box">

            <table class="table table-bordered" id="penulis-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>nama</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Tambah Penulis</h4>
        </div>
        <div class="modal-body">
            
            <form action="{{ url('admin/kategori/store') }}" method="POST" class="form-tambah">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Kategori</label>
                    <input type="text" name="nama" class="form-control" id="exampleInputEmail1" placeholder="Nama" autofocus>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Penulis</h4>
            </div>
            <div class="modal-body">
                
                <form action="{{ url('admin/kategori/delete') }}" method="POST" class="form-hapus">
                    {{ csrf_field() }}
                    
                    <p><b><i>Yakin ingin hapus kategori ini?</i></b> <i> menghapus kategori ini sama dengan menghapus semua buku yang berhubungan dengan kategori ini</i></p>
    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit-hapus">hapus</button>
                </form>
            </div>
            </div>
        </div>
    </div>

<!-- Modal Edit -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit Penulis</h4>
        </div>
        <div class="modal-body">
            
            <form action="{{ url('admin/kategori/store') }}" method="POST" class="form-edit">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Kategori</label>
                    <input type="text" name="nama_edit" class="form-control input-edit" autocomplete="off" id="exampleInputEmail1" placeholder="Nama" autofocus>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary submit-edit">Update</button>
            </form>
        </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
<script src="https://datatables.yajrabox.com/js/handlebars.js"></script>

<script>
    $(document).ready(function(){
        var flash = "{{ Session::has('pesan') }}";
        if(flash){
            var pesan = "{{ Session::get('pesan') }}";
            alert(pesan);
        }

        $('#penulis-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('user/kategori/yajra') }}",
            columns: [
                {data: 'rownum', name: 'rownum'},
                {data: 'nama', name: 'nama'},
            ]
        });

        // Ketika button tambah di klik
        $('.btn-tambah').click(function(e){
            e.preventDefault();
            // $("input[name='nama']").focus();
            $('#modal-tambah').modal();
        })

        $("button[type='submit']").click(function(e){
            e.preventDefault();
            var nama = $("input[name='nama']").val();
            
            if(nama == ''){
                alert('nama wajib diisi');
            }
            else{
                $('.form-tambah').submit();
            }
        });

        // Ketika edit kategori
        $('body').on('click', '.btn-edit', function(e){
            e.preventDefault();
            var nama = $(this).attr('nama');
            var kategori = $(this).attr('kategori-id');
            var url = "{{ url('admin/kategori/update') }}"+'/'+kategori;

            $('.form-edit').attr('action',url);
            $('.input-edit').val(nama);

            if(nama == ''){
                alert('nama wajib diisi');
            }

            $('#modal-edit').modal();
        })

        $('.submit-edit').click(function(e){
            e.preventDefault();
            var nama = $('.input-edit').val();

            if(nama == ''){
                alert('nama wajib diisi');
            }
            else{
                $('.form-edit').submit();
            }
        })

        // Ketika hapus penulis
        $('body').on('click', '.btn-hapus', function(e){
            e.preventDefault();
            var kategori_id = $(this).attr('kategori-id');
            var url = "{{ url('admin/kategori/delete') }}"+'/'+kategori_id;

            $('.form-hapus').attr('action', url);

            $('#modal-hapus').modal();
        })

        $('.submit-hapus').click(function(){
            $('.form-hapus').submit();
        })
    })
</script>

@endsection