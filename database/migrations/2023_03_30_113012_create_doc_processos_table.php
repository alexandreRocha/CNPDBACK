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
        Schema::create('doc_processos', function (Blueprint $table) {
            $table->id(); 
            $table->integer('processo_id')->nullable();
            $table->string('name')->nullable();
            $table->string('file')->nullable();
            $table->string('estado')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_processos');
    }
};
