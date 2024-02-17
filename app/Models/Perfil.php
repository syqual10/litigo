<?php 
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{ 
	protected $table = 'juriperfiles'; //Apunta a la tabla de la base de datos	
	protected $primaryKey = 'idPerfil'; //Cambia el id por defecto 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
}