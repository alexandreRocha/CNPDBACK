<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reuniao_Processo extends Model
{
    public $timestamps = false;
    protected $table = "reuniao_processos";
    protected $primaryKey="id";
    protected $fillable = [  
        
        'idReuniao',  
        'processo',
        'tipo',
        'estado',
        'descricao',
    ];
} 
