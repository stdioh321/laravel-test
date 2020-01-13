<header >
<div class="navbar-fixed">
    <nav>
    <div class="nav-wrapper orange">
      <a href="#!" class="brand-logo">Logo</a>
      <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="{{route('cursos')}}">Home</a></li>
        <li><a href="{{route('cursos.add')}}">Adicionar Curso</a></li>
        {{-- <li><a href="{{route('cursos.edit')}}">Editar Curso</a></li> --}}
        {{-- <li><a href="mobile.html">Mobile</a></li> --}}
      </ul>
    </div>
  </nav>
</div>

  <ul class="sidenav" id="mobile">
    <li><a href="{{route('cursos')}}">Home</a></li>
    <li><a href="{{route('cursos.add')}}">Adicionar Curso</a></li>
    {{-- <li><a href="{{route('cursos.edit')}}">Editar Curso</a></li> --}}
    {{-- <li><a href="mobile.html">Mobile</a></li> --}}
  </ul>
       <script>
       $(document).ready(function(){
            $('.sidenav').sidenav();
        });
  </script>
</header>