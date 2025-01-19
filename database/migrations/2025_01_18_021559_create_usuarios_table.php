<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); 
            $table->string('foto')->nullable();
            $table->string('nombres'); 
            $table->string('apellidos'); 
            $table->string('telefono');
            $table->timestamps(); 
            $table->timestamp('fecha_registro')->useCurrent();
            $table->string('estado')->default('activo'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
