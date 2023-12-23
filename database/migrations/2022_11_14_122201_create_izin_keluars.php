<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izin_keluars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('content');
            $table->dateTime('rencana_berangkat');
            $table->dateTime('rencana_kembali');
            $table->unsignedBigInteger('baak_id')->nullable(); // Tambahkan kolom 'baak_id'
            $table->foreign('baak_id')->references('id')->on('baaks')->onDelete('set null'); // Sesuaikan dengan nama tabel 'baaks'
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('izin_keluars');
    }
};
