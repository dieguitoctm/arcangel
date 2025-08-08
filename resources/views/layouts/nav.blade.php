<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #003366;">
  <div class="container">
    <!-- Logo de la municipalidad -->
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('img/coinco1.png') }}" alt="Logo Municipalidad" 
           class="img-fluid me-2" 
           style="max-height: 40px; width: auto;">
      Municipalidad Coinco
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('inscripcion.bienvenida') }}">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('inscripcion.formulario') }}">Inscripción</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('inscripcion.despedida') }}">Despedida</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.index') }}">Administración</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
