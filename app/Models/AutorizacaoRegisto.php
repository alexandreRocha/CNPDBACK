<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class autorizacaoRegisto extends Model
{
    protected $table = "autorizacao_registos";
    protected $primaryKey="id";
    protected $fillable = [
 
       'num_decisao', 
       'entidade', 
       'tipo_entidade',
       'tipo_processo',
       'anexo', 
       'idProcesso', 
       'data_decisao',
       'estado', 
       'created_at',
       'updated_at'
    ];

    protected $casts = [
    
    ];

    public function idProcesso(){
        return $this->hasOne('App\Models\Processo');
    }
     
 
}
