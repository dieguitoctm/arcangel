@extends('layouts.app')

@section('title', 'Administración Usuarios')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<div class="container py-4">

  <h1 class="mb-4 text-center">Administración Usuarios</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-responsive mb-3">
    <!-- Tabla Usuarios -->
    <table class="table table-striped table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>Nombres</th>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Teléfono</th>
          <th>Dirección</th>
          <th>RUT</th>
          <th>Registro Social</th>
          <th>Embarazada</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($usuarios as $usuario)
        <tr data-id="{{ $usuario->id }}">
          <td>{{ $usuario->nombres }}</td>
          <td>{{ $usuario->ap_paterno }}</td>
          <td>{{ $usuario->ap_materno }}</td>
          <td>{{ $usuario->telefono }}</td>
          <td>{{ $usuario->direccion }}</td>
          <td>{{ $usuario->rut }}</td>
          <td>
            @if($usuario->registro_social)
              <a href="{{ Storage::url($usuario->registro_social) }}" target="_blank" class="link-primary">Ver archivo</a>
            @else
              <span class="text-muted">No hay</span>
            @endif
          </td>
          <td>
            @if($usuario->embarazada)
              Sí ({{ $usuario->embarazada->meses_gestacion }} meses)<br>
              <a href="{{ Storage::url($usuario->embarazada->carnet_gestacion) }}" target="_blank" class="link-primary">Ver carnet</a>
            @else
              No
            @endif
          </td>
          <td class="text-nowrap">
            <button class="btn btn-primary btn-sm btn-editar" data-bs-toggle="modal" data-bs-target="#editarModal"
              data-id="{{ $usuario->id }}"
              data-nombres="{{ $usuario->nombres }}"
              data-ap_paterno="{{ $usuario->ap_paterno }}"
              data-ap_materno="{{ $usuario->ap_materno }}"
              data-telefono="{{ $usuario->telefono }}"
              data-direccion="{{ $usuario->direccion }}"
              data-rut="{{ $usuario->rut }}"
            >Editar</button>

            <button class="btn btn-danger btn-sm btn-eliminar" data-id="{{ $usuario->id }}">Eliminar</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <nav aria-label="Paginación">
    <ul class="pagination justify-content-center">
      {{ $usuarios->links('pagination::bootstrap-5') }}
    </ul>
  </nav>

  <hr>

  <!-- Tabla Menores por tutor -->
  <h2 class="mb-3">Menores Inscritos por Tutor</h2>
  @foreach($usuarios as $usuario)
    <h4 class="mb-2">Tutor: {{ $usuario->nombres }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}</h4>

    @if($usuario->menores->count() > 0)
    <div class="table-responsive mb-4">
      <table class="table table-bordered align-middle">
        <thead class="table-secondary">
          <tr>
            <th>Nombres</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>RUT</th>
            <th>Fecha Nacimiento</th>
            <th>Género</th>
            <th>Edad</th>
            <th>Carnet Control Sano</th>
            <th>Certificado de Nacimiento</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($usuario->menores as $menor)
          <tr data-id="{{ $menor->id }}">
            <td>{{ $menor->nombres }}</td>
            <td>{{ $menor->ap_paterno }}</td>
            <td>{{ $menor->ap_materno }}</td>
            <td>{{ $menor->rut }}</td>
            <td>{{ \Carbon\Carbon::parse($menor->fecha_nacimiento)->format('d-m-Y') }}</td>
            <td>{{ $menor->genero }}</td>
            <td>{{ $menor->edad }}</td>
            <td>
              @if($menor->carnet_control_sano)
                <a href="{{ Storage::url($menor->carnet_control_sano) }}" target="_blank" class="link-primary">Ver archivo</a>
              @else
                <span class="text-muted">No hay</span>
              @endif
            </td>
            <td>
              @if($menor->certificado_nacimiento)
                <a href="{{ Storage::url($menor->certificado_nacimiento) }}" target="_blank" class="link-primary">Ver archivo</a>
              @else
                <span class="text-muted">No hay</span>
              @endif
            </td>
            <td class="text-nowrap">
              <button class="btn btn-primary btn-sm btn-editar-menor" data-bs-toggle="modal" data-bs-target="#editarMenorModal"
                data-id="{{ $menor->id }}"
                data-nombres="{{ $menor->nombres }}"
                data-ap_paterno="{{ $menor->ap_paterno }}"
                data-ap_materno="{{ $menor->ap_materno }}"
                data-rut="{{ $menor->rut }}"
                data-fecha_nacimiento="{{ $menor->fecha_nacimiento }}"
                data-genero="{{ $menor->genero }}"
              >Editar</button>

              <button class="btn btn-danger btn-sm btn-eliminar-menor" data-id="{{ $menor->id }}">Eliminar</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @else
      <p>No hay menores registrados para este tutor.</p>
    @endif

    <hr>
  @endforeach


  <!-- Modal Editar Usuario -->
  <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <form id="formEditar" method="POST" action="" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editarModalLabel">Editar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="editar_id">

            <div class="row g-3">
              <div class="col-md-6">
                <label for="editar_nombres" class="form-label">Nombres</label>
                <input
                  type="text"
                  name="nombres"
                  id="editar_nombres"
                  class="form-control"
                  required
                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                  minlength="2"
                  maxlength="50"
                  placeholder="Ej: Juan Carlos"
                  title="Solo letras y espacios"
                >
                <div class="invalid-feedback">Por favor ingresa solo letras y espacios (2-50 caracteres).</div>
              </div>

              <div class="col-md-6">
                <label for="editar_telefono" class="form-label">Teléfono</label>
                <input
                  type="text"
                  name="telefono"
                  id="editar_telefono"
                  class="form-control"
                  required
                  pattern="^\+569\d{8}$"
                  minlength="12"
                  maxlength="12"
                  placeholder="+56912345678"
                  title="Debe comenzar con +569 y tener 8 números"
                >
                <div class="invalid-feedback">Por favor ingresa un teléfono válido que comience con +569 seguido de 8 números.</div>
              </div>

              <div class="col-md-6">
                <label for="editar_ap_paterno" class="form-label">Apellido Paterno</label>
                <input
                  type="text"
                  name="ap_paterno"
                  id="editar_ap_paterno"
                  class="form-control"
                  required
                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                  minlength="2"
                  maxlength="50"
                  placeholder="Ej: Pérez"
                  title="Solo letras y espacios"
                >
                <div class="invalid-feedback">Por favor ingresa solo letras y espacios (2-50 caracteres).</div>
              </div>

              <div class="col-md-6">
                <label for="editar_direccion" class="form-label">Dirección</label>
                <input
                  type="text"
                  name="direccion"
                  id="editar_direccion"
                  class="form-control"
                  required
                  maxlength="50"
                  placeholder="Ej: Calle 123, Casa 4"
                  title="Máximo 50 caracteres"
                >
                <div class="invalid-feedback">La dirección es obligatoria y debe tener máximo 50 caracteres.</div>
              </div>

              <div class="col-md-6">
                <label for="editar_ap_materno" class="form-label">Apellido Materno</label>
                <input
                  type="text"
                  name="ap_materno"
                  id="editar_ap_materno"
                  class="form-control"
                  required
                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                  minlength="2"
                  maxlength="50"
                  placeholder="Ej: González"
                  title="Solo letras y espacios"
                >
                <div class="invalid-feedback">Por favor ingresa solo letras y espacios (2-50 caracteres).</div>
              </div>

              <div class="col-md-6">
                <label for="editar_rut" class="form-label">RUT</label>
                <input
                  type="text"
                  name="rut"
                  id="editar_rut"
                  class="form-control"
                  required
                  pattern="^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$"
                  minlength="9"
                  maxlength="12"
                  placeholder="12.345.678-5"
                  title="Formato RUT chileno"
                >
                <div class="invalid-feedback">Por favor ingresa un RUT válido (formato chileno).</div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Editar Menor -->
  <div class="modal fade" id="editarMenorModal" tabindex="-1" aria-labelledby="editarMenorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <form id="formEditarMenor" method="POST" action="" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editarMenorModalLabel">Editar Menor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">

            <input type="hidden" name="id" id="editar_menor_id">

            <div class="row g-3">
              <div class="col-md-6">
                <label for="editar_menor_nombres" class="form-label">Nombres</label>
                <input
                  type="text"
                  name="nombres"
                  id="editar_menor_nombres"
                  class="form-control"
                  required
                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                  minlength="2"
                  maxlength="50"
                  placeholder="Ej: Juan Carlos"
                  title="Solo letras y espacios"
                >
                <div class="invalid-feedback">Por favor ingresa solo letras y espacios (2-50 caracteres).</div>
              </div>

              <div class="col-md-6">
                <label for="editar_menor_fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input
                  type="date"
                  name="fecha_nacimiento"
                  id="editar_menor_fecha_nacimiento"
                  class="form-control"
                  required
                  max="{{ date('Y-m-d') }}"
                >
                <div class="invalid-feedback">Por favor ingresa una fecha válida.</div>
              </div>

              <div class="col-md-6">
                <label for="editar_menor_ap_paterno" class="form-label">Apellido Paterno</label>
                <input
                  type="text"
                  name="ap_paterno"
                  id="editar_menor_ap_paterno"
                  class="form-control"
                  required
                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                  minlength="2"
                  maxlength="50"
                  placeholder="Ej: Pérez"
                  title="Solo letras y espacios"
                >
                <div class="invalid-feedback">Por favor ingresa solo letras y espacios (2-50 caracteres).</div>
              </div>

              <div class="col-md-6">
                <label for="editar_menor_genero" class="form-label">Género</label>
                <select name="genero" id="editar_menor_genero" class="form-select" required>
                  <option value="" disabled selected>Seleccione</option>
                  <option value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                  <option value="Otro">Otro</option>
                </select>
                <div class="invalid-feedback">Por favor selecciona un género.</div>
              </div>

              <div class="col-md-6">
                <label for="editar_menor_ap_materno" class="form-label">Apellido Materno</label>
                <input
                  type="text"
                  name="ap_materno"
                  id="editar_menor_ap_materno"
                  class="form-control"
                  required
                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                  minlength="2"
                  maxlength="50"
                  placeholder="Ej: González"
                  title="Solo letras y espacios"
                >
                <div class="invalid-feedback">Por favor ingresa solo letras y espacios (2-50 caracteres).</div>
              </div>

              <div class="col-md-6">
                <label for="editar_menor_rut" class="form-label">RUT</label>
                <input
                  type="text"
                  name="rut"
                  id="editar_menor_rut"
                  class="form-control"
                  required
                  pattern="^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$"
                  minlength="9"
                  maxlength="12"
                  placeholder="12.345.678-5"
                  title="Formato RUT chileno"
                >
                <div class="invalid-feedback">Por favor ingresa un RUT válido (formato chileno).</div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Usuario: Validación y edición
    const editarModal = document.getElementById('editarModal');
    const formEditar = document.getElementById('formEditar');

    formEditar.addEventListener('submit', function(event) {
        if (!formEditar.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        formEditar.classList.add('was-validated');
    });

    editarModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nombres = button.getAttribute('data-nombres');
        const ap_paterno = button.getAttribute('data-ap_paterno');
        const ap_materno = button.getAttribute('data-ap_materno');
        const telefono = button.getAttribute('data-telefono');
        const direccion = button.getAttribute('data-direccion');
        const rut = button.getAttribute('data-rut');

        document.getElementById('editar_id').value = id;
        document.getElementById('editar_nombres').value = nombres;
        document.getElementById('editar_ap_paterno').value = ap_paterno;
        document.getElementById('editar_ap_materno').value = ap_materno;
        document.getElementById('editar_telefono').value = telefono;
        document.getElementById('editar_direccion').value = direccion;
        document.getElementById('editar_rut').value = rut;

        formEditar.action = `/admin/${id}`;
        formEditar.classList.remove('was-validated');
    });

    // Usuario: Confirmación eliminar
    document.querySelectorAll('.btn-eliminar').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            if (confirm('¿Estás seguro que deseas eliminar este usuario? Esta acción no se puede deshacer.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/${id}`;
                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Menor: Validación y edición
    const editarMenorModal = document.getElementById('editarMenorModal');
    const formEditarMenor = document.getElementById('formEditarMenor');

    formEditarMenor.addEventListener('submit', function(event) {
        if (!formEditarMenor.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        formEditarMenor.classList.add('was-validated');
    });

    editarMenorModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nombres = button.getAttribute('data-nombres');
        const ap_paterno = button.getAttribute('data-ap_paterno');
        const ap_materno = button.getAttribute('data-ap_materno');
        const rut = button.getAttribute('data-rut');
        const fecha_nacimiento = button.getAttribute('data-fecha_nacimiento');
        const genero = button.getAttribute('data-genero');

        document.getElementById('editar_menor_id').value = id;
        document.getElementById('editar_menor_nombres').value = nombres;
        document.getElementById('editar_menor_ap_paterno').value = ap_paterno;
        document.getElementById('editar_menor_ap_materno').value = ap_materno;
        document.getElementById('editar_menor_rut').value = rut;
        document.getElementById('editar_menor_fecha_nacimiento').value = fecha_nacimiento;
        document.getElementById('editar_menor_genero').value = genero;

        formEditarMenor.action = `/admin/menores/${id}`;
        formEditarMenor.classList.remove('was-validated');
    });

    // Menor: Confirmación eliminar
    document.querySelectorAll('.btn-eliminar-menor').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            if (confirm('¿Estás seguro que deseas eliminar este menor? Esta acción no se puede deshacer.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/menores/${id}`;
                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
</script>

@endsection
