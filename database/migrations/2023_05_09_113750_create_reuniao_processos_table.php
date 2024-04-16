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
        Schema::create('reuniao_processos', function (Blueprint $table) {
            $table->id();
            $table->intenger('idReuniao')->nullable(); 
            $table->string('processo')->nullable();  
            $table->string('tipo')->nullable(); 
            $table->string('estado')->nullable();    
            $table->text('descricao')->nullable();    
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
        Schema::dropIfExists('reuniao_processos');
    }
};
