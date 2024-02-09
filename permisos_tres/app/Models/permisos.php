<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permisos extends Model
{
    protected $connection ="prueba";
    protected $table ="permiso"; //nombre de la tabla
    protected $primaryKey = "id";
    use HasFactory;
}
