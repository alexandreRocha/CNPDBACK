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
        Schema::create('autorizacao_registos', function (Blueprint $table) {
            $table->id();  
            $table->string('num_decisao')->nullable(); 
            $table->string('entidade')->nullable(); 
            $table->string('tipo_entidade')->nullable();
            $table->string('tipo_processo')->nullable();
            $table->string('anexo')->nullable(); 
            $table->string('idProcesso')->nullable(); 
            $table->string('data_decisao')->nullable();
            $table->string('estado')->nullable(); 
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
        Schema::dropIfExists('autorizacao_registos');
    }
};
