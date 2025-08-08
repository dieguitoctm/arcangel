@extends('layouts.app')

@section('title', 'Administración Usuarios')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Administración Usuarios</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nombres</th>
          <th>Apellido</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($usuarios as $usuario)
        <tr data-id="{{ $usuario->id }}">
          <td>{{ $usuario->nombres }}</td>
          <td>{{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}</td>
          <td>{{ $usuario->telefono }}</td>
          <td>
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

    {{ $usuarios->links() }}

    <!-- Modal Editar -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
      <div class="modal-dialog">
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
              <div class="mb-3">
                <label for="editar_nombres" class="form-label">Nombres</label>
                <input type="text" name="nombres" id="editar_nombres" class="form-control" 
                  required
                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                  minlength="2" maxlength="50"
                  title="Solo letras y espacios">
                <div class="invalid-feedback">
                  Por favor ingresa solo letras y espacios (2-50 caracteres).
                </div>
              </div>
              <div class="mb-3">
                <label for="editar_ap_paterno" class="form-label">Apellido Paterno</label>
                <input type="text" name="ap_paterno" id="editar_ap_paterno" class="form-control" 
                  required
                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                  minlength="2" maxlength="50"
                  title="Solo letras y espacios">
                <div class="invalid-feedback">
                  Por favor ingresa solo letras y espacios (2-50 caracteres).
                </div>
              </div>
              <div class="mb-3">
                <label for="editar_ap_materno" class="form-label">Apellido Materno</label>
                <input type="text" name="ap_materno" id="editar_ap_materno" class="form-control" 
                  required
                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                  minlength="2" maxlength="50"
                  title="Solo letras y espacios">
                <div class="invalid-feedback">
                  Por favor ingresa solo letras y espacios (2-50 caracteres).
                </div>
              </div>
              <div class="mb-3">
                <label for="editar_telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="editar_telefono" class="form-control" 
                  required
                  pattern="^\+569\d{8}$"
                  minlength="12" maxlength="12"
                  title="Debe comenzar con +569 y tener 8 números">
                <div class="invalid-feedback">
                  Por favor ingresa un teléfono válido que comience con +569 seguido de 8 números.
                </div>
              </div>
              <div class="mb-3">
                <label for="editar_direccion" class="form-label">Dirección</label>
                <input type="text" name="direccion" id="editar_direccion" class="form-control" 
                  required maxlength="50">
                <div class="invalid-feedback">
                  La dirección es obligatoria y debe tener máximo 50 caracteres.
                </div>
              </div>
              <div class="mb-3">
                <label for="editar_rut" class="form-label">RUT</label>
                <input type="text" name="rut" id="editar_rut" class="form-control" 
                  required
                  pattern="^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$"
                  minlength="9" maxlength="12"
                  title="Formato RUT chileno">
                <div class="invalid-feedback">
                  Por favor ingresa un RUT válido (formato chileno).
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
    const editarModal = document.getElementById('editarModal');
    const formEditar = document.getElementById('formEditar');

    // Bootstrap validation
    formEditar.addEventListener('submit', function(event) {
        if (!formEditar.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        formEditar.classList.add('was-validated');
    });

    // Al abrir el modal editar, llenar los campos
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
        // Remueve clase validación para que se limpie cuando abres el modal
        formEditar.classList.remove('was-validated');
    });

    // Confirmación eliminar
    document.querySelectorAll('.btn-eliminar').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            if (confirm('¿Estás seguro que deseas eliminar este usuario? Esta acción no se puede deshacer.')) {
                // Crear un formulario para enviar DELETE
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
});
</script>

@endsection
