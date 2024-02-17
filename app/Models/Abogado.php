<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class Abogado extends Model
{ 
	protected $table = 'juriabogados'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idAbogado'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}