<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reuniao extends Model
{
    public $timestamps = false;
    protected $table = "reuniaos";
    protected $primaryKey="id";
    protected $fillable = [  
        'tipo',
        'num_reuniao',  
        'hora_reuniao',  
        'data_reuniao',  
        'processo_parecer', 
        'processo_queixa', 
        'num_ata',
        'ordem_trab',
        'outros_assuntos',
        'anexo_ata',  
        'estadoR',
        'presid_reuniao',
        'presentes',
        'created_at',
        'updated_at',
    ];
 

    
}
