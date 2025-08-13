@extends('layouts.app')

@section('title', 'Gracias por Inscribirte')

@section('content')
<style>
    body {
        background: url('{{ asset("img/fondo1.jpg") }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .thank-you-container {
        max-width: 480px;
        margin: 60px auto;
        padding: 40px 30px;
        background: rgba(249, 249, 249, 0.95); /* fondo semi-transparente */
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        text-align: center;
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

    .btn-back-home, .btn-print-ticket {
        margin-top: 20px;
        padding: 12px 28px;
        font-size: 1.1rem;
        font-weight: 600;
        border: none;
        border-radius: 50px;
        color: white;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .btn-back-home {
        background: linear-gradient(45deg, #28a745, #34ce57);
    }

    .btn-back-home:hover {
        background: linear-gradient(45deg, #218838, #28a745);
        transform: scale(1.05);
    }

    .btn-print-ticket {
        background: linear-gradient(45deg, #007bff, #3399ff);
    }

    .btn-print-ticket:hover {
        background: linear-gradient(45deg, #0062cc, #007bff);
        transform: scale(1.05);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="thank-you-container">
    <h1>¡Gracias, {{ $usuario->nombres }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}!</h1>
    <p>Tu inscripción ha sido registrada correctamente.</p>

    <p>Tu número de inscripción es el <strong id="usuario-id">{{ $usuario->id }}</strong>.</p>

    <p>Has agregado <strong id="cantidad-menores">{{ $cantidadMenores }}</strong> menor{{ $cantidadMenores != 1 ? 'es' : '' }}.</p>

    <p>¡Felices fiestas!</p>

    <button class="btn-print-ticket" id="btnPrintTicket">🖨 Imprimir Ticket</button>
    <br>
    <a href="{{ route('inscripcion.bienvenida') }}" class="btn-back-home">← Volver al Inicio</a>
</div>

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
document.getElementById('btnPrintTicket').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: "portrait",
        unit: "mm",
        format: [80, 150] // tamaño estilo ticket
    });

    const usuarioId = document.getElementById('usuario-id').textContent;
    const cantidadMenores = document.getElementById('cantidad-menores').textContent;
    const nombreUsuario = "{{ $usuario->nombres }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}";

    doc.setFontSize(12);
    doc.text("Inscripción Navidad Coinco", 40, 15, {align: "center"});
    doc.setFontSize(10);
    doc.text(`Gracias, ${nombreUsuario}!`, 40, 25, {align: "center"});
    doc.text(`Número de Atención: ${usuarioId}`, 40, 35, {align: "center"});
    doc.text(`Cantidad de Menores: ${cantidadMenores}`, 40, 45, {align: "center"});
    doc.text("¡Felices fiestas!", 40, 55, {align: "center"});

    doc.setFontSize(8);
    doc.text("------------------------------", 40, 60, {align: "center"});
    doc.text("Generado automáticamente", 40, 65, {align: "center"});
    
    doc.save(`ticket_${usuarioId}.pdf`);
});
</script>
@endsection
