<?php
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{ 
	protected $table = 'sms'; 
	public $timestamps = false; //Desactiva fecha y hora de creación del campo 
	protected $primaryKey = 'idSms'; //Cambia el id por defecto 
}