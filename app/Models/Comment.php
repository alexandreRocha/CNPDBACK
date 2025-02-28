<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    protected $primaryKey="id";
    protected $fillable = [
 
        'user_comment',
        'idp',   
        'comments', 
        'estado',   
        'created_at',
        'updated_at',
    ];

    protected $casts = [
    
    ];

    public function idp(){
        return $this->hasOne('App\Models\Processo');
    }
}
