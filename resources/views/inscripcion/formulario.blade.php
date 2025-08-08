@extends('layouts.app')

@section('title', 'Inscripción Navidad Coinco')

@section('content')

  <div class="container py-4" style="max-width: 600px;">
    <h1 class="mb-4 text-center text-success">Formulario de Inscripción</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('inscripcion.guardar') }}" enctype="multipart/form-data" novalidate>
    @csrf

    {{-- NOMBRES --}}
    <div class="mb-3">
      <label for="nombres" class="form-label">Nombres</label>
      <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres"
      value="{{ old('nombres') }}" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo letras y espacios" minlength="2"
      maxlength="50" required autocomplete="off">
      @error('nombres')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    {{-- APELLIDO PATERNO --}}
    <div class="mb-3">
      <label for="ap_paterno" class="form-label">Apellido Paterno</label>
      <input type="text" class="form-control @error('ap_paterno') is-invalid @enderror" id="ap_paterno"
      name="ap_paterno" value="{{ old('ap_paterno') }}" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
      title="Solo letras y espacios" minlength="2" maxlength="50" required autocomplete="off">
      @error('ap_paterno')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    {{-- APELLIDO MATERNO --}}
    <div class="mb-3">
      <label for="ap_materno" class="form-label">Apellido Materno</label>
      <input type="text" class="form-control @error('ap_materno') is-invalid @enderror" id="ap_materno"
      name="ap_materno" value="{{ old('ap_materno') }}" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
      title="Solo letras y espacios" minlength="2" maxlength="50" required autocomplete="off">
      @error('ap_materno')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    {{-- TELÉFONO --}}
    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono (+569XXXXXXXX)</label>
      <input type="tel" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono"
      value="{{ old('telefono') }}" pattern="^\+569\d{8}$"
      title="Debe comenzar con +569 y tener exactamente 8 números" minlength="12" maxlength="12" required
      autocomplete="off">
      @error('telefono')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    {{-- DIRECCIÓN --}}
    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección</label>
      <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion"
      value="{{ old('direccion') }}" maxlength="50" required autocomplete="off">
      @error('direccion')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    {{-- RUT --}}
    <div class="mb-3">
      <label for="rut" class="form-label">RUT (Ej: 12.345.678-9)</label>
      <input type="text" class="form-control @error('rut') is-invalid @enderror" id="rut" name="rut"
      value="{{ old('rut') }}" pattern="^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$" title="Formato RUT chileno válido"
      minlength="9" maxlength="12" required autocomplete="off">
      @error('rut')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    {{-- REGISTRO SOCIAL --}}
    <div class="mb-3">
      <label for="registro_social" class="form-label">Registro Social de Hogares</label>
      <input type="file" class="form-control @error('registro_social') is-invalid @enderror" id="registro_social"
      name="registro_social" accept=".pdf,.jpg,.png" required>
      @error('registro_social')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    {{-- ¿Está embarazada? --}}
    <div class="mb-3">
  <label for="embarazada" class="form-label">¿Está embarazada?</label>
  <select class="form-select @error('embarazada') is-invalid @enderror" name="embarazada" id="embarazada" required>
    <option value="" disabled {{ old('embarazada') ? '' : 'selected' }}>Seleccione</option>
    <option value="si" {{ old('embarazada') == 'si' ? 'selected' : '' }}>Sí</option>
    <option value="no" {{ old('embarazada') == 'no' ? 'selected' : '' }}>No</option>
  </select>
  @error('embarazada')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

{{-- DATOS GESTACIÓN: Condicional --}}
<div id="datos-embarazo" style="display:none;">
  <div class="mb-3">
    <label for="meses_gestacion" class="form-label">Meses de Gestación</label>
    <select class="form-select @error('meses_gestacion') is-invalid @enderror" id="meses_gestacion"
      name="meses_gestacion" disabled>
      <option value="" disabled {{ old('meses_gestacion') ? '' : 'selected' }}>Seleccione</option>
      @for ($i = 1; $i <= 9; $i++)
        <option value="{{ $i }}" {{ old('meses_gestacion') == $i ? 'selected' : '' }}>{{ $i }}</option>
      @endfor
    </select>
    @error('meses_gestacion')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="carnet_gestacion" class="form-label">Carnet de Gestación (PDF/JPG/PNG máx. 2MB)</label>
    <input type="file" class="form-control @error('carnet_gestacion') is-invalid @enderror" id="carnet_gestacion"
      name="carnet_gestacion" accept=".pdf,.jpg,.png" disabled>
    @error('carnet_gestacion')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<button type="submit" class="btn btn-success w-100">Enviar Datos Usuario</button>
</form>
</div>

{{-- Mostrar/Ocultar campos de gestación --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sel = document.getElementById('embarazada');
    const box = document.getElementById('datos-embarazo');
    const meses = document.getElementById('meses_gestacion');
    const carnet = document.getElementById('carnet_gestacion');

    function toggleGestacion() {
      if (sel.value === 'si') {
        box.style.display = 'block';
        meses.disabled = false;
        carnet.disabled = false;
      } else {
        box.style.display = 'none';
        meses.disabled = true;
        meses.value = '';
        carnet.disabled = true;
        carnet.value = '';
      }
    }

    toggleGestacion();
    sel.addEventListener('change', toggleGestacion);
  });
</script>
@endsection
