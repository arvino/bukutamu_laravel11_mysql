<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('bukutamus', function (Blueprint $table) {
			$table->id();
			$table->foreignId('member_id')->constrained('members')->onDelete('cascade');
			$table->text('messages');
			$table->string('gambar')->nullable();
			$table->timestamp('timestamp')->useCurrent();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('bukutamus');
	}
};