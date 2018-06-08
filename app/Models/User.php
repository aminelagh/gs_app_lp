<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table = 'users';

	protected $primaryKey = 'id';

	protected $fillable = ['id','email', 'password', 'last_login',
	'nom', 'prenom',
	'created_at', 'updated_at'];

	protected $hidden = ['password',];
}
