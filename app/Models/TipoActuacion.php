<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class TipoActuacion extends Model
{ 
	protected $table = 'juritiposactuaciones'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idTipoActuacion'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}