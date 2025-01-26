<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
	use HasApiTokens, Notifiable;

	protected $fillable = [
		'nama',
		'phone',
		'email',
		'password',
		'role',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public function bukutamus()
	{
		return $this->hasMany(Bukutamu::class);
	}

	public function isAdmin()
	{
		return $this->role === 'admin';
	}

	public function hasPostedToday()
	{
		return $this->bukutamus()
			->whereDate('created_at', today())
			->exists();
	}
}