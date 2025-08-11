@extends('layouts.app')

@section('title', 'Inscripción Navidad Coinco')

@section('content')
<style>
    body {
        background: url('{{ asset("img/fondo1.jpg") }}') center/cover fixed no-repeat;
        transition: background-image 1s ease-in-out;
    }
    .form-wrapper {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        animation: fadeInUp 0.7s ease;
    }
    .form-title {
        font-weight: bold;
        color: #28a745;
        font-size: 1.8rem;
    }
    .btn-success {
        background: linear-gradient(45deg, #28a745, #34ce57);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-success:hover {
        background: linear-gradient(45deg, #218838, #28a745);
        transform: scale(1.02);
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .invalid-feedback {
        display: block;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="form-wrapper">
                <h1 class="mb-4 text-center form-title">🎄 Formulario de Inscripción</h1>

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
                        <input type="text" class="form-control" id="nombres" name="nombres"
                               value="{{ old('nombres') }}" minlength="2" maxlength="50" required>
                    </div>

                    {{-- APELLIDO PATERNO --}}
                    <div class="mb-3">
                        <label for="ap_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="ap_paterno" name="ap_paterno"
                               value="{{ old('ap_paterno') }}" minlength="2" maxlength="50" required>
                    </div>

                    {{-- APELLIDO MATERNO --}}
                    <div class="mb-3">
                        <label for="ap_materno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="ap_materno" name="ap_materno"
                               value="{{ old('ap_materno') }}" minlength="2" maxlength="50" required>
                    </div>

                    {{-- TELÉFONO --}}
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono (+569XXXXXXXX)</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono"
                               value="{{ old('telefono', '+569') }}" minlength="12" maxlength="12" required>
                    </div>

                    {{-- DIRECCIÓN --}}
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion"
                               value="{{ old('direccion') }}" maxlength="50" required>
                    </div>

                    {{-- RUT --}}
                    <div class="mb-3">
                        <label for="rut" class="form-label">RUT (Ej: 12.345.678-9)</label>
                        <input type="text" class="form-control" id="rut" name="rut"
                               value="{{ old('rut') }}" maxlength="12" required>
                        <div class="invalid-feedback" id="rut-error" style="display:none;">
                            RUT inválido. Revise el formato y dígito verificador.
                        </div>
                    </div>

                    {{-- REGISTRO SOCIAL --}}
                    <div class="mb-3">
                        <label for="registro_social" class="form-label">Registro Social de Hogares</label>
                        <input type="file" class="form-control" id="registro_social" name="registro_social"
                               accept=".pdf,.jpg,.png" required>
                    </div>

                    {{-- ¿Está embarazada? --}}
                    <div class="mb-3">
                        <label for="embarazada" class="form-label">¿Está embarazada?</label>
                        <select class="form-select" name="embarazada" id="embarazada" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    {{-- DATOS GESTACIÓN --}}
                    <div id="datos-embarazo" style="display:none;">
                        <div class="mb-3">
                            <label for="meses_gestacion" class="form-label">Meses de Gestación</label>
                            <select class="form-select" id="meses_gestacion" name="meses_gestacion" disabled>
                                <option value="" disabled selected>Seleccione</option>
                                @for ($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="carnet_gestacion" class="form-label">Carnet de Gestación</label>
                            <input type="file" class="form-control" id="carnet_gestacion"
                                   name="carnet_gestacion" accept=".pdf,.jpg,.png" disabled>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Enviar Datos Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Scripts para validaciones interactivas --}}
<script src="https://cdn.jsdelivr.net/npm/rut.js@1.0.2/dist/rut.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sel = document.getElementById('embarazada');
    const box = document.getElementById('datos-embarazo');
    const meses = document.getElementById('meses_gestacion');
    const carnet = document.getElementById('carnet_gestacion');
    const rutInput = document.getElementById('rut');
    const rutError = document.getElementById('rut-error');
    const telefono = document.getElementById('telefono');

    // Cambio automático de fondo
    const fondos = [
        '{{ asset("img/fondo1.jpg") }}',
        '{{ asset("img/fondo2.jpg") }}',
        '{{ asset("img/fondo3.jpg") }}'
    ];
    let fondoIndex = 0;
    setInterval(() => {
        fondoIndex = (fondoIndex + 1) % fondos.length;
        document.body.style.backgroundImage = `url('${fondos[fondoIndex]}')`;
    }, 5000);

    // Teléfono: evitar borrar +569 y solo números después
    telefono.addEventListener('input', function() {
        if (!this.value.startsWith('+569')) {
            this.value = '+569';
        }
        this.value = this.value.replace(/(?!^\+569)\D/g, '');
    });

    // Solo letras para nombres y apellidos
    ['nombres', 'ap_paterno', 'ap_materno'].forEach(id => {
        document.getElementById(id).addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
        });
    });

    // Mostrar/ocultar embarazo
    sel.addEventListener('change', function () {
        if (this.value === 'si') {
            box.style.display = 'block';
            meses.disabled = false;
            carnet.disabled = false;
        } else {
            box.style.display = 'none';
            meses.disabled = true;
            carnet.disabled = true;
            meses.value = '';
            carnet.value = '';
        }
    });

    // Validación y formato RUT
    rutInput.addEventListener('input', function () {
        let clean = this.value.replace(/[^0-9kK]/g, '');
        if (clean.length > 1) {
            clean = clean.slice(0, -1).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + clean.slice(-1);
        }
        this.value = clean;

        if (RUT.isValid(this.value)) {
            this.classList.remove('is-invalid');
            rutError.style.display = 'none';
        } else {
            this.classList.add('is-invalid');
            rutError.style.display = 'block';
        }
    });
});
</script>
@endsection
