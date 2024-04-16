<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('reuniaos', function (Blueprint $table) {
            $table->id();   
            $table->string('tipo')->nullable();
            $table->string('num_reuniao')->nullable();   
            $table->string('hora_reuniao')->nullable();   
            $table->string('data_reuniao')->nullable();  
            $table->text('processo_parecer')->nullable();  
            $table->text('processo_queixa')->nullable();  
            $table->text('outros_assuntos')->nullable();
            $table->text('ordem_trab')->nullable();   
            $table->string('num_ata')->nullable(); 
            $table->string('anexo_ata')->nullable();    
            $table->string('estadoR')->nullable(); 
            $table->string('presid_reuniao')->nullable(); 
            $table->string('presentes')->nullable(); 
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reuniaos');
    }
};
