@extends('layouts.app')

@section('title', 'Bienvenida Navidad Coinco')

@section('content')
<div style="text-align:center; padding: 40px;">
    <h1>Bienvenidos a la Inscripción Navideña</h1>

    <p>Esta página es una extensión de www.municoinco.cl para ayudar a inscribir a familias en la campaña navideña.</p>

    <img src="{{ asset('img/santa1.jpg') }}" alt="Logo Navidad" style="max-width: 200px; margin: 20px 0;">

    <br>

    <a href="{{ route('inscripcion.formulario') }}" class="btn btn-primary">Iniciar Inscripción</a>

</div>
@endsection
