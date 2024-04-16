<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspecao extends Model
{
    public $timestamps = false;
    protected $table = "inspecaos";
    protected $primaryKey="id";
    protected $fillable = [
         
        'tipo_insp',
        'entidade', 
        'id_processo',
        'created_at',
        'horai',
        'horaf',
        'local',
        'equipa_insp', 
        'receb_por_funcao', 
        'num_camara',  
        'cam_funcio', 
        'localiz_cam',  
        'aviso', 
        'som',
        'entidd_extern', 
        'num_terminal',
        'sist_alter', 
        'form_armaz',  
        'dados_recolhid', 
        'finalidade', 
        'quem_visualtemp', 
        'transm_fora', 
        'serv_grav', 
        'medid_log', 
        'tempo_conserv',    
        'anexo_equipbio', 
        'mais_obs',
        'anexo_rel',
        'estado'


        ];

        protected $casts = [
            //'equipa_insp' => 'array', 
        ];
 
}
            