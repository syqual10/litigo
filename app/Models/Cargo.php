<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{ 
	protected $table = 'cargos'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idCargo'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}