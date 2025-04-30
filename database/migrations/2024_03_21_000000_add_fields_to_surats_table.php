<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->string('jenis_surat')->after('nomor_surat')->default('domisili');
            $table->string('keperluan')->after('keterangan')->nullable();
            $table->string('dokumen')->after('keperluan')->nullable();
            $table->timestamp('approved_at')->after('status')->nullable();
            $table->timestamp('rejected_at')->after('approved_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->dropColumn(['jenis_surat', 'keperluan', 'dokumen', 'approved_at', 'rejected_at']);
        });
    }
}; 