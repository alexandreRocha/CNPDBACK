<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocProcesso extends Model
{
    public $timestamps = false; 
    protected $primaryKey="id";
    public $incrementing = true; 
    protected $table = 'doc_processos';
    protected $fillable = [
        'processo_id',
        'name',
        'file',   
        'estado',
    ];


    public function processo()
{
    return $this->belongsTo(Processo::class);
}
}
