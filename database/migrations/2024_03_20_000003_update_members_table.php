<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            // Tambahkan kolom baru jika diperlukan
            if (!Schema::hasColumn('members', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable();
            }
            // Modifikasi kolom yang sudah ada jika diperlukan
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
    }
}; 