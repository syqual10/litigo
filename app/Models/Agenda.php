<?php
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{ 
	protected $table = 'juriagendas'; 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
	protected $primaryKey = 'id'; //Cambia el id por defecto 
}