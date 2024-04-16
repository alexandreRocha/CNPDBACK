<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AutorizacaoRegisto;
use App\Models\Processo;
use App\Models\Log; 
use App\Models\Sidebar;  

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function login(Request $request)
    { 
        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->action = 'Login in';
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save(); 
        return view('home');

    }

     
    public function home()
    {
        //TOTAL DE FORMULARIOS RECEBIDOS
        $countA = DB::table('videovigilancias')->count();
        $countB = DB::table('geolocalizacaos')->count();
        $countC = DB::table('interconexaos')->count();  
        $countD = DB::table('gerals')->count();
        $countE = DB::table('tics')->count();
        $countF = DB::table('biometrias')->count(); 
        $countForms = $countA + $countB + $countC + $countD + $countE + $countF; 

        //TOTAL DE AUTOS EMITIDOS ESTE ANO
        $anoAtual = date('Y'); 
        $countAutoAnual = DB::table('autorizacao_registos')
        ->where('num_decisao', 'LIKE', '%/'.$anoAtual.'/%')
            ->count(); 

        //TOTAL DE QUEIXAS 
        $countQ = DB::table('queixas')
        ->where('num_q', 'LIKE', '%_'.$anoAtual)
            ->count(); 

        //TOTAL DE PROCESSOS
        $countP = DB::table('processos')->count();  
 
        //TOTAL DE PEDIDOS INFORMACAO
        $countPE = DB::table('pedido_informacao')->count();  
 


        //TOTAL DE PROCESSOS ATRIBUIDOS AO TECNICO
        $processos = Processo::where('responsavel_processo', Auth::user()->name)->get();
        $countMeusprocessos=count($processos); 

        //TOTAL DE AUTORIZAÇÕES DE REGISTO EMITIDO PELO TECNICO
        $minhasAuto = Processo::join('autorizacao_registos', 'autorizacao_registos.idProcesso', '=', 'processos.id')
        ->where('responsavel_processo', Auth::user()->name)
        ->get();
        $minhasAutos=count($minhasAuto);

        
 
        return view('home')
        ->with('countForms',$countForms)
        ->with('countP',$countP)
        ->with('countQ',$countQ) 
        ->with('countPE',$countPE)  
        ->with('countAutoAnual',$countAutoAnual)
        ->with('minhasAutos',$minhasAutos)
        ->with('countMeusprocessos',$countMeusprocessos);

        
    }   

 
    

    


}
