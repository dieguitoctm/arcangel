<?php

namespace App\Http\Controllers;

use App\Models\DatosUsuario;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $usuarios = DatosUsuario::with(['embarazo', 'menores'])->orderBy('created_at', 'desc')->get();
        return view('admin', compact('usuarios'));
    }
}
