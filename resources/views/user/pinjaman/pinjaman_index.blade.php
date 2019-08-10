@extends('layouts_user.master')

@section('content')

<link href="https://datatables.yajrabox.com/css/datatables.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box">

            <table class="table table-bordered" id="penulis-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>judul</th>
                        <th>Tanggal Pinjam</th>
                        <th>Harus Dikembalikan</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>



<!-- Modal Details -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Detail Buku</h4>
        </div>
        <div class="modal-body">
            
            <form action="" method="POST" class="form-edit">
                {{ csrf_field() }}

                <div>
                    <img style="width:100%" src="" class="gambar-buku" alt="">
                </div>
                <div>
                    <p class="keterangan-buku"></p>
                </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.0.0/jquery.mark.min.js"></script>
<script src="{{('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

<script id="details-template" type="text/x-handlebars-template">
    <table class="table">
        <tr>
            <td>Penulis:</td>
            <td>@{{penulis}}</td>
        </tr>
        <tr>
            <td>Kategori:</td>
            <td>@{{kategori}}</td>
        </tr>
        <tr>
            <td>Tahun</td>
            <td>@{{tahun}}</td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="btn btn-block btn-primary btn-detail" buku-id=@{{buku_id}}>Detail</button>
            </td>
        </tr>
    </table>
</script>

<script>
    $(document).ready(function(){
        var flash = "{{ Session::has('pesan') }}";
        if(flash){
            var pesan = "{{ Session::get('pesan') }}";
            alert(pesan);
        }

        $('.textarea').wysihtml5()

        // $('.select2').select2()

        var template = Handlebars.compile($("#details-template").html());

        var table = $('#penulis-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('user/pinjaman/yajra') }}",
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "searchable":     false,
                    "data":           null,
                    "defaultContent": ''
                },
                {data: 'rownum', name: 'rownum'},
                {data: 'judul', name: 'judul'},
                {data: 'tanggal_pinjam', name: 'tanggal_pinjam'},
                {data: 'tanggal_kembali', name: 'tanggal_kembali'},
                {data: 'status', name: 'status'}
            ],
            order: [[1, 'asc']]
        });

        // Add event listener for opening and closing details
        $('#penulis-table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( template(row.data()) ).show();
                tr.addClass('shown');
            }
        });

        // Ketika button tambah di klik
        $('.btn-tambah').click(function(e){
            e.preventDefault();
            // $("input[name='nama']").focus();
            $('#modal-tambah').modal();
        })

        $("button[type='submit']").click(function(e){
            e.preventDefault();
            var judul = $("input[name='judul']").val();
            var penulis = $("input[name='penulis']").val();
            var kategori_id = $("select[name='kategori_id']").val();
            var tahun = $("input[name='tahun']").val();
            var keterangan = $("textarea[name='keterangan']").val();
            
            if(judul == ''){
                alert('Judul wajib diisi');
            }else if(penulis == ''){
                alert('penulis wajib diisi');
            }else if(tahun == ''){
                alert('tahun wajib diisi');
            }else if(keterangan == ''){
                alert('keterangan buku wajib diisi');
            }else if(kategori_id == null){
                alert('Kategori wajib dipilih');
            }else{
                $('.form-tambah').submit();
            }
        });

        // Ketika edit buku
        $('body').on('click', '.btn-edit', function(e){
            e.preventDefault();
            var buku_id = $(this).attr('buku-id');
            var url = "{{ url('admin/buku/update') }}"+'/'+buku_id;

            $('#buku-id').text(buku_id);

            $('.form-edit').attr('action',url);
            // $('.input-edit').val(nama);
            // $('.kode-edit').val(kode);


            $('#modal-edit').modal();
        })

        $('.submit-edit').click(function(e){
            e.preventDefault();
            var nama = $('.input-edit').val();
            var kode = $('.kode-edit').val();

            if(nama == ''){
                alert('nama wajib diisi');
            }else if(kode == ''){
                alert('kode wajib diisi');
            }
            else{
                $('.form-edit').submit();
            }
        })

        // Ketika hapus penulis
        $('body').on('click', '.btn-hapus', function(e){
            e.preventDefault();
            var buku_id = $(this).attr('buku-id');
            var url = "{{ url('admin/buku/delete') }}"+'/'+buku_id;

            $('.form-hapus').attr('action', url);

            $('#modal-hapus').modal();
        })

        $('.submit-hapus').click(function(){
            $('.form-hapus').submit();
        })

        // Ketika button detail di klik
        $('body').on('click','.btn-detail',function(e){
            e.preventDefault();
            var buku_id = $(this).attr('buku-id');
            var url = "{{ url('user/buku/ajax-detail') }}"+'/'+buku_id;
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: url,
                success: function(data){
                    console.log(data);
                    var gambar = data.gambar;
                    var photo = "{{ asset('uploads') }}"+'/'+gambar;
                    var keterangan = data.keterangan;
                    var kt = $.parseHTML(data.keterangan);

                    $('.gambar-buku').attr('src',photo);
                    $('.keterangan-buku').empty();
                    $('.keterangan-buku').append(keterangan);
                }
            });

            $('#modal-detail').modal();
        })

        // Ketika minjam buku
        // $('body').on('click','.btn-pinjaman',function(e){
        //     e.preventDefault();
        //     var buku_id = $(this).attr('buku-id');
        //     var url = "{{ url('user/pinjaman/store') }}"+'/'+buku_id;

        //     window.location.href = url;
        // });
    })
</script>

@endsection