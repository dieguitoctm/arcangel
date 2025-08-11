@extends('layouts.app')

@section('title', 'Gracias por Inscribirte')

@section('content')
<style>
    .thank-you-container {
        max-width: 480px;
        margin: 60px auto;
        padding: 40px 30px;
        background: #f9f9f9;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        text-align: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #2c3e50;
        animation: fadeInUp 0.8s ease forwards;
    }
    .thank-you-container h1 {
        color: #28a745;
        font-weight: 700;
        font-size: 2.6rem;
        margin-bottom: 20px;
    }
    .thank-you-container p {
        font-size: 1.1rem;
        margin-bottom: 16px;
    }
    .thank-you-container strong {
        color: #155724;
        font-weight: 700;
    }
    .btn-back-home {
        margin-top: 30px;
        padding: 12px 28px;
        font-size: 1.1rem;
        font-weight: 600;
        background: linear-gradient(45deg, #28a745, #34ce57);
        border: none;
        border-radius: 50px;
        color: white;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s ease, transform 0.3s ease;
    }
    .btn-back-home:hover {
        background: linear-gradient(45deg, #218838, #28a745);
        transform: scale(1.05);
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="thank-you-container">
    <h1>¡Gracias por inscribirte!</h1>
    <p>Tu inscripción ha sido registrada correctamente.</p>

    <p>Tu número de inscripción es el <strong>{{ $usuario->id }}</strong>.</p>

    <p>Has agregado <strong>{{ $cantidadMenores }}</strong> menor{{ $cantidadMenores != 1 ? 'es' : '' }}.</p>

    <p>¡Felices fiestas!</p>

    <a href="{{ route('inscripcion.bienvenida') }}" class="btn-back-home">← Volver al Inicio</a>
</div>
@endsection
