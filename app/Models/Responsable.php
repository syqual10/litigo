<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{ 
	protected $table = 'juriresponsables'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idResponsable'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}