@extends('layouts.app')

@section('title', 'Agregar Menores al Tutor')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Agregar Menores para Tutor: {{ $usuario->nombres }} {{ $usuario->ap_paterno }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <p>Puedes agregar uno o más menores ligados a este tutor. También puedes terminar sin agregar menores.</p>

    <form method="POST" action="{{ route('menor.guardar', $usuario->id) }}" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="mb-3">
            <label for="nombres">Nombres</label>
            <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ap_paterno">Apellido Paterno</label>
            <input type="text" name="ap_paterno" id="ap_paterno" value="{{ old('ap_paterno') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ap_materno">Apellido Materno</label>
            <input type="text" name="ap_materno" id="ap_materno" value="{{ old('ap_materno') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="rut">RUT (Ej: 12.345.678-9)</label>
            <input type="text" name="rut" id="rut" value="{{ old('rut') }}" class="form-control" maxlength="12" required>
        </div>

        <div class="mb-3">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="genero">Género</label>
            <select name="genero" id="genero" class="form-select" required>
                <option value="" selected disabled>Seleccione</option>
                <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="carnet_control_sano">Carnet de Control de Salud (PDF/JPG/PNG)</label>
            <input type="file" name="carnet_control_sano" id="carnet_control_sano" class="form-control" accept=".pdf,.jpg,.png" required>
        </div>

        <div class="mb-3">
            <label for="certificado_nacimiento">Certificado de Nacimiento (PDF/JPG/PNG)</label>
            <input type="file" name="certificado_nacimiento" id="certificado_nacimiento" class="form-control" accept=".pdf,.jpg,.png" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Agregar Menor</button>
    </form>

    <hr>

    <a href="{{ route('inscripcion.despedida') }}" class="btn btn-success w-100 mt-3">Finalizar sin agregar más menores</a>
</div>
@endsection
