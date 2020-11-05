<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compradores', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->integer('documento');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email');
            $table->enum('genero', ['M','F']);

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compradores');
    }
}
