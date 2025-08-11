<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosUsuario;
use App\Models\Embarazada;
use Illuminate\Support\Facades\Storage;

class InscripcionController extends Controller
{
    // Página de bienvenida
    public function bienvenida()
    {
        return view('bienvenida');
    }

    // Mostrar formulario tutor (usuario + embarazo)
    public function formulario()
    {
        return view('inscripcion.formulario'); // formulario solo tutor + embarazo
    }

    // Guardar tutor + embarazo y redirigir a agregar menores
    public function guardar(Request $request)
    {
        $request->validate([
            'nombres' => 'required|regex:/^[\pL\s]+$/u',
            'ap_paterno' => 'required|regex:/^[\pL\s]+$/u',
            'ap_materno' => 'required|regex:/^[\pL\s]+$/u',
            'telefono' => 'required|regex:/^\+569\d{8}$/',
            'direccion' => 'required|max:50',
            'rut' => 'required|regex:/^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$/|unique:datos_usuarios,rut',
            'registro_social' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'embarazada' => 'nullable|in:si,no',
            'meses_gestacion' => 'required_if:embarazada,si|integer|min:1|max:9',
            'carnet_gestacion' => 'required_if:embarazada,si|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $archivoRegistroSocial = $request->file('registro_social')->store('public/archivos');

        $usuario = DatosUsuario::create([
            'nombres' => $request->nombres,
            'ap_paterno' => $request->ap_paterno,
            'ap_materno' => $request->ap_materno,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'rut' => $request->rut,
            'registro_social' => $archivoRegistroSocial,
        ]);

        if ($request->embarazada === 'si') {
            $archivoCarnet = $request->file('carnet_gestacion')->store('public/archivos');
            Embarazada::create([
                'usuario_id' => $usuario->id,
                'meses_gestacion' => $request->meses_gestacion,
                'carnet_gestacion' => $archivoCarnet,
            ]);
        }

        return redirect()->route('menor.formulario', $usuario->id)
            ->with('success', 'Tutor registrado correctamente. Ahora puede agregar menores o finalizar.');
    }

    // Listar usuarios en admin
    public function index()
    {
        $usuarios = DatosUsuario::with(['embarazada', 'menores'])->paginate(10);
        return view('admin', compact('usuarios'));
    }

    // Otros métodos edit, update, destroy y despedida (igual que antes)
    public function despedida($usuario = null)
    {
        if (!$usuario) {
            // Si no hay usuario, redirige al inicio o muestra mensaje
            return redirect()->route('inscripcion.bienvenida');
        }

        // Carga el usuario con sus menores
        $usuario = DatosUsuario::with('menores')->find($usuario);

        if (!$usuario) {
            return redirect()->route('inscripcion.bienvenida')->with('error', 'Usuario no encontrado.');
        }

        $cantidadMenores = $usuario->menores->count();

        return view('despedida', compact('usuario', 'cantidadMenores'));
    }
}
