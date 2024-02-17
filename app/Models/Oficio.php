<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{ 
	protected $table = 'juriconsecutivosoficios'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idConsecutivoOficio'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}