<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{ 
	protected $table = 'ciudades'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idCiudad'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}