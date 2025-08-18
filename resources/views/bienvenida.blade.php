@extends('layouts.app')

@section('title', 'Bienvenida Navidad Coinco')

@section('content')
<style>
    /* Estilos base para móviles */
    body {
        font-size: 18px;
    }
    
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0,0,0,0.5)), 
                    url('{{ asset("img/fondo1.jpg") }}') center/cover no-repeat;
        color: white;
        text-align: center;
        padding: 5rem 1.5rem;
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    
    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        animation: fadeInDown 1s ease-in-out;
    }
    
    .hero-section p {
        font-size: 1.4rem;
        max-width: 100%;
        margin: 0 auto 2rem;
        line-height: 1.5;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        animation: fadeInUp 1s ease-in-out;
    }
    
    .hero-section a {
        font-size: 1.5rem;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: bold;
        animation: fadeIn 1.5s ease-in-out;
    }
    
    .option-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
        margin-bottom: 1.5rem;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .option-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    
    .card-body {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }
    
    .card-title {
        font-size: 1.8rem;
        margin: 1.5rem 0;
        font-weight: bold;
    }
    
    .card-text {
        font-size: 1.3rem;
        line-height: 1.5;
    }
    
    .bi {
        font-size: 4rem !important;
    }
    
    /* Animaciones */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Media queries para tablets */
    @media (min-width: 768px) {
        .hero-section {
            padding: 7rem 2rem;
            min-height: 70vh;
        }
        
        .hero-section h1 {
            font-size: 3.5rem;
        }
        
        .hero-section p {
            font-size: 1.6rem;
            max-width: 80%;
        }
        
        .card-title {
            font-size: 2rem;
        }
        
        .card-text {
            font-size: 1.4rem;
        }
    }
    
    /* Media queries para desktop */
    @media (min-width: 992px) {
        .hero-section {
            padding: 8rem 2rem;
            min-height: 80vh;
        }
        
        .hero-section h1 {
            font-size: 4rem;
        }
        
        .hero-section p {
            font-size: 1.8rem;
            max-width: 700px;
        }
        
        .hero-section a {
            font-size: 1.8rem;
            padding: 1.2rem 2.5rem;
        }
    }
</style>

<div class="hero-section">
    <h1>🎄 Bienvenidos a la Inscripción Navideña 2025 🎅</h1>
    <p>Extensión de <a href="https://www.municoinco.cl" target="_blank" style="color: #ffdf6c; font-weight: bold; text-decoration: none;">municoinco.cl</a> para inscribir a familias en la campaña navideña de Coinco.  
    Vive la magia de esta Navidad con nosotros.</p>
    <a href="{{ route('inscripcion.formulario') }}" class="btn btn-warning btn-lg mt-4">
        <i class="bi bi-pencil-square"></i> Iniciar Inscripción
    </a>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-12 col-md-4 mb-4">
            <div class="card option-card">
                <div class="card-body">
                    <i class="bi bi-gift-fill text-danger"></i>
                    <h5 class="card-title">Regalos para Niños</h5>
                    <p class="card-text">Inscribe a los más pequeños para recibir un regalo especial esta Navidad.</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-4">
            <div class="card option-card">
                <div class="card-body">
                    <i class="bi bi-heart-fill text-success"></i>
                    <h5 class="card-title">Apoyo a Familias</h5>
                    <p class="card-text">Participa de los programas solidarios de fin de año y comparte la alegría.</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-4">
            <div class="card option-card">
                <div class="card-body">
                    <i class="bi bi-calendar-event-fill text-primary"></i>
                    <h5 class="card-title">Eventos Navideños</h5>
                    <p class="card-text">Infórmate de todas las actividades navideñas que tendremos en Coinco.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection