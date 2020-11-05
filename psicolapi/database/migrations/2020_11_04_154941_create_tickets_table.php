<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->string('nombre');
            $table->integer('disponible')->unsigned();
            $table->date('fecha_evento');
            $table->string('lugar');

            $table->engine = 'InnoDB';
        });

        DB::connection('mysql')->table('tickets')->insert([
            [
                'nombre' => 'Concierto Juan Luis Guerra',
                'disponible' => 125,
                'fecha_evento' => '2020-12-08',
                'lugar' => 'Parque Simón Bolivar, Bogotá'
            ],
            [
                'nombre' => 'Donación de Juguetes',
                'disponible' => 100,
                'fecha_evento' => '2020-12-15',
                'lugar' => "Centro Comercial Caracolí, Bucaramanga"
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
