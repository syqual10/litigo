<?php
namespace SQ10;
namespace SQ10\models;
use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'solicitantes'; 

	//Desactiva fecha y hora de creación del campo 
	protected $primaryKey = 'idSolicitante'; //Cambia el id por defecto 

	public $timestamps = false; 

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function getRememberToken()
	{
	    return $this->remember_token;
	}

	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
	    return 'remember_token';
	}

}