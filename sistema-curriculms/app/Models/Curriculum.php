<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curricula';

    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono',
        'correo',
        'fecha_nacimiento',
        'nota_media',
        'experiencia',
        'formacion',
        'habilidades',
        'fotografia'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'nota_media' => 'decimal:2'
    ];

    // Accesor para obtener el nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellidos;
    }

    // Accesor para calcular la edad
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento->age;
    }
}