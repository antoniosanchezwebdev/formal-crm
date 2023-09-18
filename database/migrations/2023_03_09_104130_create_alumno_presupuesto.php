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
        Schema::create('presupuestos_alumno_curso', function (Blueprint $table) {
            $table->id();
            $table->integer('alumno_id')->nullable();
            $table->integer('presupuesto_id')->nullable();
            $table->integer('curso_id')->nullable();
            $table->decimal('precio')->nullable();
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
        Schema::dropIfExists('presupuestos_alumno_curso');
    }
};
