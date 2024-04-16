<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunicacaoterceiro extends Model
{
    public $timestamps = false;
    protected $table = "comunicacaoterceiros";
    protected $primaryKey="id";
    protected $fillable = [
        'idForm',
        'entidades_comunicadas',
        'condicoes_comunicacao',
        'dados_transferidos',
        'tipoform'
    ];

    public function forms(){
        return $this->hasOne('App\Models\Interconexao');
    }
    public function formsGeral(){
        return $this->hasOne('App\Models\Geral');
    }
 
}