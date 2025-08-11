@extends('layouts.app')

@section('title', 'Bienvenida Navidad Coinco')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0,0,0,0.4)), 
                    url('{{ asset("img/fondo1.jpg") }}') center/cover no-repeat;
        color: white;
        text-align: center;
        padding: 80px 20px;
    }
    .hero-section h1 {
        font-size: 2.8rem;
        font-weight: bold;
        animation: fadeInDown 1s ease-in-out;
    }
    .hero-section p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: auto;
        animation: fadeInUp 1s ease-in-out;
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .option-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }
    .option-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
</style>

<div class="hero-section">
    <h1>🎄 Bienvenidos a la Inscripción Navideña 2025 🎅</h1>
    <p>Extensión de <a href="https://www.municoinco.cl" target="_blank" style="color: #ffdf6c; font-weight: bold;">municoinco.cl</a> para inscribir a familias en la campaña navideña de Coinco.  
    Vive la magia de esta Navidad con nosotros.</p>
    <a href="{{ route('inscripcion.formulario') }}" class="btn btn-warning btn-lg mt-4">
        <i class="bi bi-pencil-square"></i> Iniciar Inscripción
    </a>
</div>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card option-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-gift-fill text-danger" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Regalos para Niños</h5>
                    <p class="card-text">Inscribe a los más pequeños para recibir un regalo especial esta Navidad.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card option-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-heart-fill text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Apoyo a Familias</h5>
                    <p class="card-text">Participa de los programas solidarios de fin de año y comparte la alegría.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card option-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-calendar-event-fill text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Eventos Navideños</h5>
                    <p class="card-text">Infórmate de todas las actividades navideñas que tendremos en Coinco.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
