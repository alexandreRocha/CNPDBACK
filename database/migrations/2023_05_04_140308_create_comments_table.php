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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();   
            $table->string('user_comment')->nullable();
            $table->integer('idp')->nullable();   
            $table->text('comments')->nullable(); 
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
        Schema::dropIfExists('comments');
    }
};
