@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registro de Menor</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('menor.guardar', $usuario->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Campos -->
        <div class="mb-3">
            <label for="nombres">Nombres</label>
            <input type="text" name="nombres" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ap_paterno">Apellido Paterno</label>
            <input type="text" name="ap_paterno" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ap_materno">Apellido Materno</label>
            <input type="text" name="ap_materno" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="rut">RUT</label>
            <input type="text" name="rut" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="genero">Género</label>
            <select name="genero" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="carnet_control_sano">Carnet Control Sano (PDF)</label>
            <input type="file" name="carnet_control_sano" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="certificado_nacimiento">Certificado de Nacimiento (PDF)</label>
            <input type="file" name="certificado_nacimiento" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Menor</button>
        <a href="{{ route('inscripcion.despedida') }}" class="btn btn-secondary">Finalizar</a>
    </form>
</div>
@endsection
