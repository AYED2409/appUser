<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enlace extends Model
{
    use HasFactory;
    
    // public $timestamps = false;

    protected $table = 'enlace';
    protected $fillable = [
        'iduser',
        'titulo',
        'descripcion',
        'enlace',
        'imagen',
        'visitas',
        'fechaCreacion',
        'fechaEdicion'
    ];
    
    public function user() {
        return $this->belongsTo ('App\Models\User', 'iduser');
    }
    
    public function enlaces () {
        return $this->hasMany ('App\Models\EnlaceEtiqueta', 'idenlace');
    }



}
