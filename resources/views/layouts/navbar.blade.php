@section('navbar')
<nav class="navbar bg-white bg-opacity-10 bg-body-tertiary shadow">
  <div class="container-fluid col ">
    <a class="navbar-brand d-flex align-items-center" href="home.php">
      <img src="img/brand/logoMain.svg" alt="Logo" width="7%" height="7%" class="d-inline-block align-text-top ml-5">
      <h1 class="ml-4"> Verse <span style="color: #b77e23;">Guru</span> </h1>
    </a>
  </div>
  <div class="container-fluid col w-100">
    <div class="navbar__container mx-auto">
        <div class="row">
            <div class="navbar__item m-3">
                <a href="#" class="formatlink"><span> HOME </span></a>
            </div>
            <div class="navbar__item m-3">
               <a href="#" class="formatlink"><span> BIBLE </span></a>
            </div>
            <div class="navbar__item m-3">
                <a href="#" class="formatlink"><span> BOOKMARKS </span></a>
            </div>
            <div class="navbar__item m-3">
                <a href="#" class="formatlink"><span> HISTORY </span></a>
            </div>
            <div class="navbar__item m-3">
                <a href="#" class="formatlink"><span> PROFILE </span></a>
            </div>
        </div>
    </div>
  </div>  
</nav>
@endsection