<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class TipoActoAdministrativo extends Model
{ 
	protected $table = 'juritiposactosadministrativos'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idTipoActo'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}