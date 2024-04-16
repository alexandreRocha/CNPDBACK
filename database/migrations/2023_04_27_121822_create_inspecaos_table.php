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
        Schema::create('inspecaos', function (Blueprint $table) {
            $table->id();   
            $table->string('tipo_insp')->nullable();
            $table->string('entidade')->nullable(); 
            $table->integer('id_processo')->nullable();
            $table->string('created_at')->nullable();
            $table->string('horai')->nullable();
            $table->string('horaf')->nullable();
            $table->string('local')->nullable();
            $table->string('equipa_insp')->nullable(); 
            $table->string('receb_por_funcao')->nullable(); 
            $table->string('num_camara')->nullable();  
            $table->string('cam_funcio')->nullable(); 
            $table->string('localiz_cam')->nullable();  
            $table->string('aviso')->nullable(); 
            $table->string('som')->nullable();
            $table->string('entidd_extern')->nullable(); 
            $table->string('num_terminal')->nullable();
            $table->string('sist_alter')->nullable(); 
            $table->string('form_armaz')->nullable();  
            $table->string('dados_recolhid')->nullable(); 
            $table->string('finalidade')->nullable(); 
            $table->string('quem_visualtemp')->nullable(); 
            $table->string('transm_fora')->nullable(); 
            $table->string('serv_grav')->nullable(); 
            $table->string('medid_log')->nullable(); 
            $table->string('tempo_conserv')->nullable();    
            $table->string('anexo_equipbio')->nullable(); 
            $table->string('mais_obs')->nullable();
            $table->string('anexo_rel')->nullable();
            $table->string('estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspecaos');
    }
};
