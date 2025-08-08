<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embarazada extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'meses_gestacion', 'carnet_gestacion'];

    // Relación inversa
    public function usuario()
    {
        return $this->belongsTo(DatosUsuario::class, 'usuario_id');
    }
}
