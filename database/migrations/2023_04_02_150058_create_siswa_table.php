<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nis');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->date('tgl_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('jenis_kelamin');
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'kelas_id']);
        });
        Schema::dropIfExists('siswas');
    }
}
