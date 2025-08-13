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

    /* Validación: mensajes ocultos por defecto */
    .invalid-feedback { display: none; color: #dc3545; font-size: 0.875em; }
    .valid-feedback { display: none; color: #198754; font-size: 0.875em; }

    /* Mostrar mensajes solo tras validación */
    .was-validated select:invalid ~ .invalid-feedback,
    .was-validated select:valid ~ .valid-feedback,
    .was-validated input:invalid ~ .invalid-feedback,
    .was-validated input:valid ~ .valid-feedback { display: block; }

    /* Estilos para inputs válidos e inválidos */
    .was-validated select:invalid, 
    .was-validated input:invalid { border-color: #dc3545; background-image: none; }
    .was-validated select:valid,
    .was-validated input:valid {
        border-color: #198754;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23198754' viewBox='0 0 8 8'%3e%3cpath d='M6.564 1.75L3.25 5.064 1.436 3.25 0 4.686l3.25 3.25 5-5z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    /* Precarga de archivos */
    .file-loading {
        font-size: 0.9rem;
        color: #555;
        margin-top: 5px;
        display: none;
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

                <form method="POST" action="{{ route('inscripcion.guardar') }}" enctype="multipart/form-data" novalidate id="form-inscripcion">
                    @csrf

                    {{-- NOMBRES --}}
                    <div class="mb-3">
                        <label for="nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres"
                               value="{{ old('nombres') }}" minlength="2" maxlength="50" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$">
                        <div class="invalid-feedback">Ingrese un nombre válido (solo letras).</div>
                        <div class="valid-feedback">¡Perfecto!</div>
                    </div>

                    {{-- APELLIDO PATERNO --}}
                    <div class="mb-3">
                        <label for="ap_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="ap_paterno" name="ap_paterno"
                               value="{{ old('ap_paterno') }}" minlength="2" maxlength="50" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$">
                        <div class="invalid-feedback">Ingrese un apellido válido (solo letras).</div>
                        <div class="valid-feedback">¡Perfecto!</div>
                    </div>

                    {{-- APELLIDO MATERNO --}}
                    <div class="mb-3">
                        <label for="ap_materno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="ap_materno" name="ap_materno"
                               value="{{ old('ap_materno') }}" minlength="2" maxlength="50" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$">
                        <div class="invalid-feedback">Ingrese un apellido válido (solo letras).</div>
                        <div class="valid-feedback">¡Perfecto!</div>
                    </div>

                    {{-- TELÉFONO --}}
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono (+569XXXXXXXX)</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono"
                               value="{{ old('telefono', '+569') }}" minlength="12" maxlength="12" required pattern="^\+569\d{8}$">
                        <div class="invalid-feedback">Ingrese un teléfono válido en formato +569XXXXXXXX.</div>
                        <div class="valid-feedback">¡Perfecto!</div>
                    </div>

                    {{-- DIRECCIÓN --}}
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion"
                               value="{{ old('direccion') }}" maxlength="50" required>
                        <div class="invalid-feedback">Ingrese una dirección (máximo 50 caracteres).</div>
                        <div class="valid-feedback">¡Perfecto!</div>
                    </div>

                    {{-- RUT --}}
                    <div class="mb-3">
                        <label for="rut" class="form-label">RUT (Ej: 12.345.678-9)</label>
                        <input type="text" class="form-control" id="rut" name="rut"
                               value="{{ old('rut') }}" maxlength="12" required>
                        <div class="invalid-feedback" id="rut-error" style="display:none;">
                            RUT inválido. Revise el formato y dígito verificador.
                        </div>
                        <div class="valid-feedback">¡Perfecto!</div>
                    </div>

                    {{-- REGISTRO SOCIAL --}}
                    <div class="mb-3">
                        <label for="registro_social" class="form-label">Registro Social de Hogares</label>
                        <input type="file" class="form-control" id="registro_social" name="registro_social"
                               accept=".pdf,.jpg,.png" required>
                        <div class="file-loading" id="registro_social_loading">Cargando archivo...</div>
                        <div class="invalid-feedback">Debe subir un archivo válido (PDF/JPG/PNG).</div>
                        <div class="valid-feedback">¡Perfecto!</div>
                    </div>

                    {{-- ¿Está embarazada? --}}
                    <div class="mb-3">
                        <label for="embarazada" class="form-label">¿Está embarazada o solo desea agregar un niño?</label>
                        <select class="form-select" name="embarazada" id="embarazada" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="si">Sí, estoy embarazada.</option>
                            <option value="no">No, solo deseo inscribir un niño.</option>
                        </select>
                        <div class="invalid-feedback">Por favor, seleccione una opción.</div>
                        <div class="valid-feedback">¡Perfecto!</div>
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
                            <div class="file-loading" id="carnet_gestacion_loading">Cargando archivo...</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Enviar Datos Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Scripts para validaciones interactivas y precarga de archivos --}}
<script src="https://cdn.jsdelivr.net/npm/rut.js@1.0.2/dist/rut.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-inscripcion');
    const sel = document.getElementById('embarazada');
    const box = document.getElementById('datos-embarazo');
    const meses = document.getElementById('meses_gestacion');
    const carnet = document.getElementById('carnet_gestacion');
    const rutInput = document.getElementById('rut');
    const rutError = document.getElementById('rut-error');
    const telefono = document.getElementById('telefono');

    // Fondo automático
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

    // Teléfono
    telefono.addEventListener('input', function() {
        if (!this.value.startsWith('+569')) this.value = '+569';
        this.value = this.value.replace(/(?!^\+569)\D/g, '');
    });

    // Nombres y apellidos solo letras
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

    // Validación RUT
    rutInput.addEventListener('input', function () {
        let clean = this.value.replace(/[^0-9kK]/g, '');
        if (clean.length > 1) {
            clean = clean.slice(0, -1).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + clean.slice(-1);
        }
        this.value = clean;
        if (RUT.isValid(this.value)) {
            this.classList.remove('is-invalid'); this.classList.add('is-valid'); rutError.style.display = 'none';
        } else {
            this.classList.remove('is-valid'); this.classList.add('is-invalid'); rutError.style.display = 'block';
        }
    });

    // Validación general
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // === Precarga de archivos ===
    function handleFilePreload(input, loaderId) {
        const loader = document.getElementById(loaderId);
        input.addEventListener('change', function() {
            if (this.files.length > 0) {
                loader.style.display = 'inline-block';
                // Simular carga corta
                setTimeout(() => loader.style.display = 'none', 1000);
            }
        });
    }

    handleFilePreload(document.getElementById('registro_social'), 'registro_social_loading');
    handleFilePreload(document.getElementById('carnet_gestacion'), 'carnet_gestacion_loading');
});
</script>
@endsection
