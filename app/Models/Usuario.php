<?php

namespace SQ10;
namespace SQ10\models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'usuarios'; 

    //Desactiva fecha y hora de creación del campo 
    protected $primaryKey = 'idUsuario'; //Cambia el id por defecto 

    public $timestamps = false; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}