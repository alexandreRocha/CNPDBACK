<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspefotos extends Model
{
    public $timestamps = false;
    protected $table = "inspefotos";
    protected $primaryKey="id";
    protected $fillable = [
          
        'idInspecao', 
        'anexo',
        'estado'
    ];
}
