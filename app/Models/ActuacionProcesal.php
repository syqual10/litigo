<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class ActuacionProcesal extends Model
{ 
	protected $table = 'juriactuaciones'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idActuacion'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}