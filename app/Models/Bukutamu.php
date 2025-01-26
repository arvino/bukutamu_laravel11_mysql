<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bukutamu extends Model
{
	protected $fillable = [
		'member_id',
		'messages',
		'gambar',
		'timestamp'
	];

	protected $casts = [
		'timestamp' => 'datetime'
	];

	public function member(): BelongsTo
	{
		return $this->belongsTo(Member::class);
	}
}