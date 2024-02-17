<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class RadicadoActo extends Model
{ 
	protected $table = 'juriradicadoacto'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idRadicadoActo'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}