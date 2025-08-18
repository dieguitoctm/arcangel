@extends('layouts.app')

@section('title', 'Gracias por Inscribirte')

@section('content')
<style>
    body {
        background: url('{{ asset("img/fondo1.jpg") }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
    }

    .thank-you-container {
        width: 94%;
        max-width: 94%;
        margin: 30px auto;
        padding: 40px 25px;
        background: rgba(249, 249, 249, 0.97);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        text-align: center;
        color: #2c3e50;
        animation: fadeInUp 0.8s ease forwards;
    }

    .thank-you-container h1 {
        color: #28a745;
        font-weight: 700;
        font-size: 2.4rem;
        margin-bottom: 30px;
        line-height: 1.3;
    }

    .thank-you-container p {
        font-size: 1.4rem;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .thank-you-container strong {
        color: #155724;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .btn-back-home, .btn-print-ticket {
        margin: 20px auto;
        padding: 18px 35px;
        font-size: 1.4rem;
        font-weight: 600;
        border: none;
        border-radius: 50px;
        color: white;
        cursor: pointer;
        text-decoration: none;
        display: block;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 400px;
    }

    .btn-back-home {
        background: linear-gradient(45deg, #28a745, #34ce57);
    }

    .btn-back-home:hover {
        background: linear-gradient(45deg, #218838, #28a745);
        transform: scale(1.03);
    }

    .btn-print-ticket {
        background: linear-gradient(45deg, #007bff, #3399ff);
    }

    .btn-print-ticket:hover {
        background: linear-gradient(45deg, #0062cc, #007bff);
        transform: scale(1.03);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Media Queries para mejor responsividad */
    @media (min-width: 768px) {
        .thank-you-container {
            width: 85%;
            max-width: 600px;
            padding: 50px 40px;
            margin: 60px auto;
        }
        
        .thank-you-container h1 {
            font-size: 2.8rem;
        }
        
        .thank-you-container p {
            font-size: 1.5rem;
        }
        
        .btn-back-home, .btn-print-ticket {
            display: inline-block;
            width: auto;
            padding: 15px 40px;
            margin: 20px 15px;
            font-size: 1.3rem;
        }
    }

    @media (max-width: 480px) {
        .thank-you-container {
            width: 96%;
            padding: 35px 20px;
            margin: 20px auto;
        }
        
        .thank-you-container h1 {
            font-size: 2.2rem;
        }
        
        .thank-you-container p {
            font-size: 1.3rem;
        }
        
        .btn-back-home, .btn-print-ticket {
            font-size: 1.3rem;
            padding: 16px 30px;
        }
    }
</style>

<div class="thank-you-container">
    <h1>¡Gracias, {{ $usuario->nombres }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}!</h1>
    <p>Tu inscripción ha sido registrada correctamente.</p>

    <p>Tu número de inscripción es el <strong id="usuario-id">{{ $usuario->id }}</strong>.</p>

    <p>Has agregado <strong id="cantidad-menores">{{ $cantidadMenores }}</strong> menor{{ $cantidadMenores != 1 ? 'es' : '' }}.</p>

    <p>¡Felices fiestas!</p>

    <button class="btn-print-ticket" id="btnPrintTicket">🖨 Imprimir Ticket</button>
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
        format: [80, 150]
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