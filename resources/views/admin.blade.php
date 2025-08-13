@extends('layouts.app')

@section('title', 'Administración Usuarios y Menores')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<style>
body {
    background: url('{{ asset("img/fondo1.jpg") }}') no-repeat center center fixed;
    background-size: cover;
}
table.dataTable thead { background-color: #343a40 !important; color: #fff; }
table.dataTable tbody tr:hover { background-color: #cfe2ff !important; }
.dt-button.buttons-excel { background-color: #198754 !important; color: white !important; }
.dt-button.buttons-pdf { background-color: #dc3545 !important; color: white !important; }

/* Menores por tutor ocultos por defecto */
#menoresPorTutor { display: none; margin-top: 30px; }
.tutor-card { background-color: rgba(255,255,255,0.9); border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow:0 4px 12px rgba(0,0,0,0.2);}
.tutor-card h4 { margin-bottom: 15px; }
.menores-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:15px; }
.menor-card { background-color: #f8f9fa; border-radius:10px; padding:15px; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
.menor-card h5 { margin-bottom:8px; }
</style>

<div class="container py-4">

<h1 class="mb-4 text-center text-white">Administración Usuarios y Menores</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Tabla Usuarios -->
<div class="table-responsive mb-5">
    <h2 class="text-white mb-3">Usuarios</h2>
    <table id="usuariosTable" class="table table-striped table-hover align-middle" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>Nombres</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Teléfono</th>
                <th>Dirección</th><th>RUT</th><th>Registro Social</th><th>Embarazada</th><th>Acciones</th>
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
            <td>@if($usuario->registro_social)<a href="{{ Storage::url($usuario->registro_social) }}" target="_blank" class="link-primary">Ver archivo</a>@else<span class="text-muted">No hay</span>@endif</td>
            <td>@if($usuario->embarazada)Sí ({{ $usuario->embarazada->meses_gestacion }} meses)<br><a href="{{ Storage::url($usuario->embarazada->carnet_gestacion) }}" target="_blank" class="link-primary">Ver carnet</a>@else No @endif</td>
            <td class="text-nowrap">
                <button class="btn btn-primary btn-sm btn-editar" data-bs-toggle="modal" data-bs-target="#editarModal"
                data-id="{{ $usuario->id }}" data-nombres="{{ $usuario->nombres }}"
                data-ap_paterno="{{ $usuario->ap_paterno }}" data-ap_materno="{{ $usuario->ap_materno }}"
                data-telefono="{{ $usuario->telefono }}" data-direccion="{{ $usuario->direccion }}"
                data-rut="{{ $usuario->rut }}">Editar</button>
                <button class="btn btn-danger btn-sm btn-eliminar" data-id="{{ $usuario->id }}">Eliminar</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Tabla Menores -->
<div class="table-responsive mb-4">
    <h2 class="text-white mb-3">Menores Inscritos</h2>
    <table id="menoresTable" class="table table-striped table-hover align-middle" style="width:100%">
        <thead class="table-dark">
            <tr><th>Nombre Tutor</th><th>RUT Tutor</th><th>Nombre Menor</th><th>RUT Menor</th><th>Edad</th><th>Ver más</th></tr>
        </thead>
        <tbody>
        @foreach($usuarios as $usuario)
            @foreach($usuario->menores as $menor)
            <tr>
                <td>{{ $usuario->nombres }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}</td>
                <td>{{ $usuario->rut }}</td>
                <td>{{ $menor->nombres }} {{ $menor->ap_paterno }} {{ $menor->ap_materno }}</td>
                <td>{{ $menor->rut }}</td>
                <td>{{ $menor->edad }}</td>
                <td><button class="btn btn-info btn-sm btn-ver-mas" data-id="{{ $menor->id }}">Ver más</button></td>
            </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>

<!-- Botón Ver Más Menores por Tutor -->
<div class="text-center mb-4">
    <button id="btnVerMasMenores" class="btn btn-warning">Ver todos los menores por tutor</button>
</div>

<!-- Menores por Tutor (Cartas) -->
<div id="menoresPorTutor">
    <h2 class="text-white mb-3">Menores por Tutor</h2>
    @foreach($usuarios as $usuario)
        @if($usuario->menores->count()>0)
        <div class="tutor-card">
            <h4>{{ $usuario->nombres }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }} ({{ $usuario->menores->count() }} menores)</h4>
            <div class="menores-grid">
            @foreach($usuario->menores as $menor)
                <div class="menor-card">
                    <h5>{{ $menor->nombres }} {{ $menor->ap_paterno }} {{ $menor->ap_materno }}</h5>
                    <p><strong>RUT:</strong> {{ $menor->rut }}</p>
                    <p><strong>Edad:</strong> {{ $menor->edad }}</p>
                    <p><strong>Fecha Nac:</strong> {{ \Carbon\Carbon::parse($menor->fecha_nacimiento)->format('d-m-Y') }}</p>
                    <p><strong>Género:</strong> {{ $menor->genero }}</p>
                    <p><strong>Carnet Control Sano:</strong> @if($menor->carnet_control_sano)<a href="{{ Storage::url($menor->carnet_control_sano) }}" target="_blank" class="link-primary">Ver archivo</a>@else<span class="text-muted">No hay</span>@endif</p>
                    <p><strong>Certificado Nacimiento:</strong> @if($menor->certificado_nacimiento)<a href="{{ Storage::url($menor->certificado_nacimiento) }}" target="_blank" class="link-primary">Ver archivo</a>@else<span class="text-muted">No hay</span>@endif</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm btn-editar-menor" data-bs-toggle="modal"
                            data-bs-target="#editarMenorModal" data-id="{{ $menor->id }}" data-nombres="{{ $menor->nombres }}"
                            data-ap_paterno="{{ $menor->ap_paterno }}" data-ap_materno="{{ $menor->ap_materno }}"
                            data-rut="{{ $menor->rut }}" data-fecha_nacimiento="{{ $menor->fecha_nacimiento }}"
                            data-genero="{{ $menor->genero }}">Editar</button>
                        <button class="btn btn-danger btn-sm btn-eliminar-menor" data-id="{{ $menor->id }}">Eliminar</button>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        @endif
    @endforeach
</div>

<!-- Modales Editar Usuario y Menor -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
<form id="formEditar" method="POST" action="" class="needs-validation" novalidate>
@csrf @method('PUT')
<div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Editar Usuario</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
<input type="hidden" id="editar_id">
<div class="row g-3">
<div class="col-md-6">
<label>Nombres</label>
<input type="text" id="editar_nombres" name="nombres" class="form-control" required maxlength="50">
<div class="invalid-feedback">Solo letras, máximo 50 caracteres.</div>
</div>
<div class="col-md-6">
<label>Teléfono</label>
<input type="text" id="editar_telefono" name="telefono" class="form-control" required maxlength="12">
<div class="invalid-feedback">Formato +569XXXXXXXX</div>
</div>
<div class="col-md-6">
<label>Apellido Paterno</label>
<input type="text" id="editar_ap_paterno" name="ap_paterno" class="form-control" required maxlength="50">
<div class="invalid-feedback">Solo letras, máximo 50 caracteres.</div>
</div>
<div class="col-md-6">
<label>Dirección</label>
<input type="text" id="editar_direccion" name="direccion" class="form-control" required maxlength="50">
<div class="invalid-feedback">Máximo 50 caracteres.</div>
</div>
<div class="col-md-6">
<label>Apellido Materno</label>
<input type="text" id="editar_ap_materno" name="ap_materno" class="form-control" required maxlength="50">
<div class="invalid-feedback">Solo letras, máximo 50 caracteres.</div>
</div>
<div class="col-md-6">
<label>RUT</label>
<input type="text" id="editar_rut" name="rut" class="form-control" required pattern="^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$" maxlength="12">
<div class="invalid-feedback">RUT inválido (ej. 12.345.678-9)</div>
</div>
</div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary">Guardar Cambios</button></div>
</div>
</form>
</div>
</div>

<div class="modal fade" id="editarMenorModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
<form id="formEditarMenor" method="POST" action="" class="needs-validation" novalidate>
@csrf @method('PUT')
<div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Editar Menor</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
<input type="hidden" id="editar_menor_id">
<div class="row g-3">
<div class="col-md-6">
<label>Nombres</label>
<input type="text" id="editar_menor_nombres" name="nombres" class="form-control" required maxlength="50">
<div class="invalid-feedback">Solo letras, máximo 50 caracteres.</div>
</div>
<div class="col-md-6">
<label>Fecha de Nacimiento</label>
<input type="date" id="editar_menor_fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
<div class="invalid-feedback">Seleccione fecha válida (0-6 años).</div>
</div>
<div class="col-md-6">
<label>Apellido Paterno</label>
<input type="text" id="editar_menor_ap_paterno" name="ap_paterno" class="form-control" required maxlength="50">
<div class="invalid-feedback">Solo letras, máximo 50 caracteres.</div>
</div>
<div class="col-md-6">
<label>Género</label>
<select id="editar_menor_genero" name="genero" class="form-select" required>
<option value="">Selecciona...</option><option value="Masculino">Masculino</option><option value="Femenino">Femenino</option><option value="Otro">Otro</option>
</select>
<div class="invalid-feedback">Seleccione género.</div>
</div>
<div class="col-md-6">
<label>Apellido Materno</label>
<input type="text" id="editar_menor_ap_materno" name="ap_materno" class="form-control" required maxlength="50">
<div class="invalid-feedback">Solo letras, máximo 50 caracteres.</div>
</div>
<div class="col-md-6">
<label>RUT</label>
<input type="text" id="editar_menor_rut" name="rut" class="form-control" required pattern="^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$" maxlength="12">
<div class="invalid-feedback">RUT inválido (ej. 12.345.678-9)</div>
</div>
</div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary">Guardar Cambios</button></div>
</div>
</form>
</div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function(){

// Inicializar DataTables con exportación
$('#usuariosTable, #menoresTable').DataTable({
    dom: 'Bfrtip',
    buttons: ['excelHtml5','pdfHtml5'],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-CL.json' }
});

// Modal editar usuario
$('.btn-editar').click(function(){
    let btn = $(this);
    $('#editar_id').val(btn.data('id'));
    $('#editar_nombres').val(btn.data('nombres'));
    $('#editar_ap_paterno').val(btn.data('ap_paterno'));
    $('#editar_ap_materno').val(btn.data('ap_materno'));
    $('#editar_telefono').val(btn.data('telefono') || '+569');
    $('#editar_direccion').val(btn.data('direccion'));
    $('#editar_rut').val(btn.data('rut'));
    $('#formEditar').attr('action','/admin/'+btn.data('id'));
});

// Eliminar usuario
$('.btn-eliminar').click(function(){
    if(confirm('¿Eliminar usuario?')){
        $('<form>',{'method':'POST','action':'/admin/'+$(this).data('id')}).append('@csrf<input type="hidden" name="_method" value="DELETE">').appendTo('body').submit();
    }
});

// Modal editar menor
$('.btn-editar-menor').click(function(){
    let btn = $(this);
    $('#editar_menor_id').val(btn.data('id'));
    $('#editar_menor_nombres').val(btn.data('nombres'));
    $('#editar_menor_ap_paterno').val(btn.data('ap_paterno'));
    $('#editar_menor_ap_materno').val(btn.data('ap_materno'));
    $('#editar_menor_rut').val(btn.data('rut'));
    $('#editar_menor_fecha_nacimiento').val(btn.data('fecha_nacimiento'));
    $('#editar_menor_genero').val(btn.data('genero'));
    $('#formEditarMenor').attr('action','/admin/menores/'+btn.data('id'));
});

// Eliminar menor
$('.btn-eliminar-menor').click(function(){
    if(confirm('¿Eliminar menor?')){
        $('<form>',{'method':'POST','action':'/admin/menores/'+$(this).data('id')}).append('@csrf<input type="hidden" name="_method" value="DELETE">').appendTo('body').submit();
    }
});

// Bootstrap validaciones
(function(){
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form){
        form.addEventListener('submit',function(event){
            if(!form.checkValidity()){ event.preventDefault(); event.stopPropagation(); }
            form.classList.add('was-validated');
        },false);
    });
})();

// Bloquear números en nombres/apellidos
$('#editar_nombres,#editar_ap_paterno,#editar_ap_materno,#editar_menor_nombres,#editar_menor_ap_paterno,#editar_menor_ap_materno')
.on('keypress',function(e){if(!/^[a-zA-ZáéíóúÁÉÍÓÚ\s]*$/.test(String.fromCharCode(e.which))) e.preventDefault();});

// Bloquear letras en teléfono
$('#editar_telefono').on('keypress',function(e){if(!/[0-9+]/.test(String.fromCharCode(e.which))) e.preventDefault();});

// Ver más menores por tutor
$('#btnVerMasMenores').click(function(){
    $('#menoresPorTutor').slideToggle();
});
});
</script>

@endsection
