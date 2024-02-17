<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class ActuacionResponsable extends Model
{ 
	protected $table = 'juriactuacionesresponsables'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idActuacionResponsable'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}