<div class="user-panel">
    <div class="pull-left image">
      <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p>Alexander Pierce</p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>
  <!-- search form -->
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search...">
      <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
    </div>
  </form>
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li><a href="{{ url('user') }}"><i class="fa fa-book"></i> <span>Beranda</span></a></li>
    <li><a href="{{ url('user/buku') }}"><i class="fa fa-book"></i> <span>Buku</span></a></li>
    <li><a href="{{ url('user/kategori') }}"><i class="fa fa-book"></i> <span>Kategori</span></a></li>
    <li><a href="{{ url('user/pinjaman') }}"><i class="fa fa-book"></i> <span>Buku Yang Saya Pinjam</span></a></li>
    <li><a href="{{ url('keluar') }}"><i class="fa fa-book"></i> <span>Log Out</span></a></li>
    <li class="header">LABELS</li>
    <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
  </ul>