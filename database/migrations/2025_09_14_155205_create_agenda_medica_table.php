<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agendas_medicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained()->onDelete('cascade');
            $table->time('hora_inicio');          
            $table->time('hora_fim');             
            $table->integer('duracao_consulta');  
            $table->json('dias_semana');          
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agendas_medicas');
    }
};
