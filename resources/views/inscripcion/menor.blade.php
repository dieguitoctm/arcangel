@extends('layouts.app')

@section('title', 'Agregar Menores al Tutor')

@section('head')
    {{-- No necesitas CSS extra para input type=date --}}
@endsection

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
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.7s ease;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-title {
            font-weight: bold;
            color: #0d6efd;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(45deg, #0d6efd, #0056b3);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #0d6efd);
            transform: scale(1.02);
        }

        .btn-success {
            background: linear-gradient(45deg, #198754, #146c43);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(45deg, #146c43, #198754);
            transform: scale(1.02);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: scale(1.02);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Validación: mensajes ocultos por defecto */
        .invalid-feedback {
            display: none;
            color: #dc3545;
            font-size: 0.875em;
        }

        /* Mostrar mensajes solo tras validación */
        .was-validated .form-control:invalid ~ .invalid-feedback,
        .was-validated .form-select:invalid ~ .invalid-feedback {
            display: block;
        }

        /* Borde rojo solo si inválido y validado */
        .was-validated .form-control:invalid {
            border-color: #dc3545;
        }

        #form-menor {
            display: none;
        }
    </style>

    <div class="container py-5">
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

            <p class="mb-4 text-center">¿Desea agregar un menor ligado a este tutor?</p>

            <div class="d-flex justify-content-center gap-3 mb-4">
                <button id="btn-yes" class="btn btn-primary">Sí, agregar menor</button>
                <a href="{{ route('inscripcion.despedida', $usuario->id) }}" class="btn btn-success">No, finalizar inscripción</a>
            </div>

            <form id="form-menor" method="POST" action="{{ route('menor.guardar', $usuario->id) }}"
                enctype="multipart/form-data" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" class="form-control"
                        required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" minlength="2" maxlength="50" autocomplete="off">
                    <div class="invalid-feedback">Ingrese un nombre válido (solo letras).</div>
                </div>

                <div class="mb-3">
                    <label for="ap_paterno" class="form-label">Apellido Paterno</label>
                    <input type="text" name="ap_paterno" id="ap_paterno" value="{{ old('ap_paterno') }}"
                        class="form-control" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" minlength="2" maxlength="50"
                        autocomplete="off">
                    <div class="invalid-feedback">Ingrese un apellido válido (solo letras).</div>
                </div>

                <div class="mb-3">
                    <label for="ap_materno" class="form-label">Apellido Materno</label>
                    <input type="text" name="ap_materno" id="ap_materno" value="{{ old('ap_materno') }}"
                        class="form-control" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" minlength="2" maxlength="50"
                        autocomplete="off">
                    <div class="invalid-feedback">Ingrese un apellido válido (solo letras).</div>
                </div>

                <div class="mb-3">
                    <label for="rut" class="form-label">RUT (Ej: 12.345.678-9)</label>
                    <input type="text" name="rut" id="rut" value="{{ old('rut') }}" class="form-control" maxlength="12"
                        required autocomplete="off">
                    <div class="invalid-feedback" id="rut-error" style="display:none;">RUT inválido. Revise el formato y
                        dígito verificador.</div>
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                        min="{{ \Carbon\Carbon::now()->subYears(6)->format('Y-m-d') }}"
                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                        value="{{ old('fecha_nacimiento') }}"
                        class="form-control" required autocomplete="off" placeholder="Seleccione fecha">
                    <div class="invalid-feedback">Debe tener menos de 6 años.</div>
                </div>

                <div class="mb-3">
                    <label for="genero" class="form-label">Género</label>
                    <select name="genero" id="genero" class="form-select" required>
                        <option value="" selected disabled>Seleccione</option>
                        <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    <div class="invalid-feedback">Seleccione un género.</div>
                </div>

                <div class="mb-3">
                    <label for="carnet_control_sano" class="form-label">Carnet de Control de Salud (PDF/JPG/PNG)</label>
                    <input type="file" name="carnet_control_sano" id="carnet_control_sano" class="form-control"
                        accept=".pdf,.jpg,.png" required>
                    <div class="invalid-feedback">Debe subir un archivo válido (PDF/JPG/PNG).</div>
                </div>

                <div class="mb-3">
                    <label for="certificado_nacimiento" class="form-label">Certificado de Nacimiento (PDF/JPG/PNG)</label>
                    <input type="file" name="certificado_nacimiento" id="certificado_nacimiento" class="form-control"
                        accept=".pdf,.jpg,.png" required>
                    <div class="invalid-feedback">Debe subir un archivo válido (PDF/JPG/PNG).</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">Agregar Menor</button>
                    <button type="button" id="btn-cancel" class="btn btn-secondary flex-grow-1">Cancelar</button>
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
            });

            // Ocultar formulario al cancelar y mostrar pregunta
            btnCancel.addEventListener('click', () => {
                form.style.display = 'none';
                btnYes.style.display = 'inline-block';
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

            // Validación bootstrap custom para campos con fecha dentro de rango
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
