<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class PuntoAtencion extends Model
{ 
	protected $table = 'juripuntosatencion'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idPuntoAtencion'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}