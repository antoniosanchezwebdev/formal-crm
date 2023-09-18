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
        Schema::create('monitores', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->nullable();
            $table->string("apellidos")->nullable();
            $table->string("dni")->nullable();
            $table->string("pais")->nullable();
            $table->string("movil")->nullable();
            $table->string("email")->nullable();
            $table->string("firma")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitores');
    }
};
