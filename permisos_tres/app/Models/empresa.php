<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;


class empresa extends  Authenticatable
{
    protected $connection ="prueba";
    protected $table ="cargo"; //nombre de la tabla
    protected $primaryKey = "id";
    protected $guard_name = 'web';



    use HasFactory, HasRoles;
}
