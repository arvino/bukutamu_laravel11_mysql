<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable implements MustVerifyEmail
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

	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed',
	];

	public function bukutamu()
	{
		return $this->hasMany(Bukutamu::class);
	}

	public function isAdmin()
	{
		return $this->role === 'admin';
	}

	public function canSubmitToday()
	{
		return !$this->bukutamu()
			->whereDate('created_at', today())
			->exists();
	}
}