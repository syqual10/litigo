<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class LogsJuridica extends Model
{ 
	protected $table = 'logs_juridica'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idlog'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}