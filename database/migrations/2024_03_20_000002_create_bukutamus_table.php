<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bukutamus')) {
            Schema::create('bukutamus', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->text('messages');
                $table->string('gambar')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bukutamus');
    }
}; 