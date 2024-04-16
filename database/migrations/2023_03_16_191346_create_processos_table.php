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
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('num_processo')->nullable();
            $table->string('entidade')->nullable();
            $table->string('tipo_entidade')->nullable(); ;
            $table->string('descricao_processo')->nullable(); 
            $table->string('tipo_processo')->nullable();
            $table->string('num_duc')->nullable();
            $table->string('preco_pago')->nullable();
            $table->string('num_duc')->nullable();
            $table->string('data_Pagaduc')->nullable();
            $table->string('anexo_forms')->nullable(); 
            $table->string('anexo_duc')->nullable(); 
            $table->string('estadoD')->nullable(); 
            $table->string('estadoP')->nullable(); 
            $table->integer('idForm')->nullable(); 
            $table->string('num_notadesp')->nullable(); 
            $table->string('anexo_notadesp')->nullable();  
            $table->string('responsavel_processo')->nullable(); 
            $table->string('data_receber_processo')->nullable(); 
            $table->string('qrcode')->nullable();  
            $table->string('aviso')->nullable();  
            $table->boolean('p_urgente')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processos');
    }
};
