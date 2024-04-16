<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory;
    protected $table = "processos";
    protected $primaryKey="id";
    protected $fillable = [
 
            'created_at',
            'updated_at',
            'num_processo',
            'entidade',
            'tipo_entidade',
            'descricao_processo',
            'tipo_processo', 
            'preco_pago',
            'num_duc',
            'data_Pagaduc',
            'anexo_forms', 
            'anexo_duc',
            'estadoD',
            'estadoP', 
            'idForm', 
            'num_notadesp',
            'anexo_notadesp',
            'responsavel_processo', 
            'data_receber_processo', 
            'qrcode',
            'aviso',
            'p_urgente'
    ];

    

        public function processo_forms(){
            return $this->hasOne(
            'App\Models\Tic',
            'App\Models\Geral',
            'App\Models\Biometria',
            'App\Models\Geolocalizao',
            'App\Models\Interconexao',
            'App\Models\Videovigilancia');
        }

        public function docProcessos()
        {
            return $this->hasMany(DocProcesso::class);
        }

        public function autorizacao()
        {
            return $this->hasOne(AutorizacaoRegisto::class, 'idProcesso');
        }
        

}