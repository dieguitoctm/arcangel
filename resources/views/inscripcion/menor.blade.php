@extends('layouts.app')

@section('title', 'Agregar Menores al Tutor')

@section('content')
<style>
    body {
        background: url('{{ asset("img/fondo1.jpg") }}') center/cover fixed no-repeat;
        margin: 0;
        padding: 0;
    }
    .form-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(5px);
        padding: 1.5rem;
        border-radius: 0;
        box-shadow: none;
        width: 100%;
        min-height: 100vh;
        margin: 0;
    }
    .form-title {
        font-weight: bold;
        color: #0d6efd;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .form-label {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-control, .form-select {
        font-size: 1.1rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        width: 100%;
        border: 2px solid #ddd;
        border-radius: 0.5rem;
    }
    .btn {
        padding: 1.2rem;
        font-size: 1.2rem;
        border-radius: 0.5rem;
        margin: 0.5rem 0;
    }
    .btn-primary {
        background: linear-gradient(45deg, #0d6efd, #0056b3);
        border: none;
    }
    .btn-success {
        background: linear-gradient(45deg, #198754, #146c43);
        border: none;
    }
    .btn-secondary {
        background: #6c757d;
        border: none;
        color: white;
    }
    .invalid-feedback {
        font-size: 1rem;
        margin-top: -1rem;
        margin-bottom: 1rem;
    }
    .alert {
        font-size: 1.1rem;
        padding: 1rem;
    }
    .d-flex.gap-3 {
        gap: 1rem !important;
    }

    /* Estilos para móviles pequeños */
    @media (max-width: 576px) {
        .form-title {
            font-size: 1.8rem;
        }
        .form-label {
            font-size: 1.1rem;
        }
        .form-control, .form-select {
            font-size: 1rem;
            padding: 0.8rem;
        }
        .btn {
            padding: 1rem;
            font-size: 1.1rem;
        }
    }

    /* Estilos para pantallas más grandes */
    @media (min-width: 768px) {
        .form-wrapper {
            max-width: 600px;
            margin: 2rem auto;
            min-height: auto;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.3);
        }
    }
</style>

<div class="container-fluid p-0">
    <div class="form-wrapper">
        <h1 class="form-title">Agregar Menores para Tutor: <br>{{ $usuario->nombres }} {{ $usuario->ap_paterno }}</h1>

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

        <p class="mb-4 text-center" style="font-size: 1.2rem;">¿Desea agregar un menor ligado a este tutor?</p>

        <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mb-4">
            <button id="btn-yes" class="btn btn-primary">Sí, agregar menor</button>
            <a href="{{ route('inscripcion.despedida', $usuario->id) }}" class="btn btn-success">No, finalizar inscripción</a>
        </div>

        <form id="form-menor" method="POST" action="{{ route('menor.guardar', $usuario->id) }}"
            enctype="multipart/form-data" novalidate style="display: none;">
            @csrf

            <div class="form-group">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" class="form-control"
                    required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" minlength="2" maxlength="50" autocomplete="off">
                <div class="invalid-feedback">Ingrese un nombre válido (solo letras).</div>
            </div>

            <div class="form-group">
                <label for="ap_paterno" class="form-label">Apellido Paterno</label>
                <input type="text" name="ap_paterno" id="ap_paterno" value="{{ old('ap_paterno') }}"
                    class="form-control" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" minlength="2" maxlength="50"
                    autocomplete="off">
                <div class="invalid-feedback">Ingrese un apellido válido (solo letras).</div>
            </div>

            <div class="form-group">
                <label for="ap_materno" class="form-label">Apellido Materno</label>
                <input type="text" name="ap_materno" id="ap_materno" value="{{ old('ap_materno') }}"
                    class="form-control" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" minlength="2" maxlength="50"
                    autocomplete="off">
                <div class="invalid-feedback">Ingrese un apellido válido (solo letras).</div>
            </div>

            <div class="form-group">
                <label for="rut" class="form-label">RUT (Ej: 12.345.678-9)</label>
                <input type="text" name="rut" id="rut" value="{{ old('rut') }}" class="form-control" maxlength="12"
                    required autocomplete="off">
                <div class="invalid-feedback" id="rut-error">RUT inválido. Revise el formato y dígito verificador.</div>
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                    min="{{ \Carbon\Carbon::now()->subYears(6)->format('Y-m-d') }}"
                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                    value="{{ old('fecha_nacimiento') }}"
                    class="form-control" required autocomplete="off" placeholder="Seleccione fecha">
                <div class="invalid-feedback">Debe tener menos de 6 años.</div>
            </div>

            <div class="form-group">
                <label for="genero" class="form-label">Género</label>
                <select name="genero" id="genero" class="form-select" required>
                    <option value="" selected disabled>Seleccione</option>
                    <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
                <div class="invalid-feedback">Seleccione un género.</div>
            </div>

            <div class="form-group">
                <label for="carnet_control_sano" class="form-label">Carnet de Control de Salud (PDF/JPG/PNG)</label>
                <input type="file" name="carnet_control_sano" id="carnet_control_sano" class="form-control"
                    accept=".pdf,.jpg,.png" required>
                <div class="invalid-feedback">Debe subir un archivo válido (PDF/JPG/PNG).</div>
            </div>

            <div class="form-group">
                <label for="certificado_nacimiento" class="form-label">Certificado de Nacimiento (PDF/JPG/PNG)</label>
                <input type="file" name="certificado_nacimiento" id="certificado_nacimiento" class="form-control"
                    accept=".pdf,.jpg,.png" required>
                <div class="invalid-feedback">Debe subir un archivo válido (PDF/JPG/PNG).</div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-2">
                <button type="submit" class="btn btn-primary">Agregar Menor</button>
                <button type="button" id="btn-cancel" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/rut.js@1.0.2/dist/rut.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rutInput = document.getElementById('rut');
        const rutError = document.getElementById('rut-error');
        const form = document.getElementById('form-menor');
        const btnYes = document.getElementById('btn-yes');
        const btnCancel = document.getElementById('btn-cancel');
        const fechaNacimiento = document.getElementById('fecha_nacimiento');

        // Mostrar formulario al dar "Sí"
        btnYes.addEventListener('click', () => {
            form.style.display = 'block';
            btnYes.style.display = 'none';
            window.scrollTo(0, 0);
        });

        // Ocultar formulario al cancelar y mostrar pregunta
        btnCancel.addEventListener('click', () => {
            form.style.display = 'none';
            btnYes.style.display = 'block';
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

        // Bloquear números en nombres y apellidos
        function bloquearNumeros(input) {
            input.addEventListener('input', () => {
                input.value = input.value.replace(/[0-9]/g, '');
            });
        }
        bloquearNumeros(document.getElementById('nombres'));
        bloquearNumeros(document.getElementById('ap_paterno'));
        bloquearNumeros(document.getElementById('ap_materno'));

        // Validación fecha
        form.addEventListener('submit', function (event) {
            const minDate = new Date(fechaNacimiento.min);
            const maxDate = new Date(fechaNacimiento.max);
            const selectedDate = new Date(fechaNacimiento.value);

            if (selectedDate < minDate || selectedDate > maxDate) {
                fechaNacimiento.setCustomValidity('Debe tener menos de 6 años.');
            } else {
                fechaNacimiento.setCustomValidity('');
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>
@endsection