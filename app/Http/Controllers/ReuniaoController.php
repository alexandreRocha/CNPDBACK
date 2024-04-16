<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use App\Models\Reuniao;
use App\Models\AutorizacaoRegisto;
use App\Models\Reuniao_Processo;
use App\Models\Videovigilancia;
use App\Models\Interconexao;
use App\Models\Biometria;
use App\Models\Geral;
use App\Models\Tic;
use App\Models\Geolocalizacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Log;
use PDF;

class ReuniaoController extends Controller
{
     
    public function index()
    {
        if (Gate::allows('fullMenu')) { 
            $reunioes = Reuniao::orderBy('created_at')->get(); 
            //TOTAL DE PROCESSOS PRONTOS PARA SEREM APROVADOS PELOS MEMBROS
            $processosParaAprovacao = Processo::where('estadoP', 'AGUARDANDO APROVAÇÃO')->get();  

            return view('reunioes.index')->with('reunioes',$reunioes)->with('processosParaAprovacao',$processosParaAprovacao); 
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
    }



 
    public function reunioesAgenda()
    {
        if (Gate::allows('fullMenu')) {  
            $reunioes = Reuniao::where('estadoR', 'Agendada')->get();  
            //TOTAL DE PROCESSOS PRONTOS PARA SEREM APROVADOS PELOS MEMBROS
            $processosParaAprovacao = Processo::where('estadoP', 'AGUARDANDO APROVAÇÃO')->get();  
            return view('reunioes.reunioesAgenda')->with('reunioes',$reunioes)->with('processosParaAprovacao',$processosParaAprovacao); 
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
    }
     





    public function agendarR(Request $request)
    {
        $reuniao = new Reuniao();
        // $processosSelecionados será um array contendo os IDs dos processos selecionadas
        $processosSelecionados = $request->input('categorias'); 

        if($processosSelecionados !=""){
            $getReuniao = Reuniao::latest()->first();

        if($getReuniao){
            $numReu = $getReuniao['num_reuniao'];
            $newNumReu=explode("_",$numReu); //2_2023
            if($newNumReu[1]==date('Y')){//ultimo reuniao de 2023
                $newNum= $newNumReu[0]+1;
                $reuniao->num_reuniao =$newNum."_".date('Y');
            }else{ //ultimo num doc e de ano anterior
                $reuniao->num_reuniao ="1_".date('Y');
            }  
        }else{
            $reuniao->num_reuniao ="1_".date('Y');
        }

        $reuniao->tipo = "Ordinária";
        $reuniao->processo_parecer= $request->processo_parecer;
        $reuniao->processo_queixa= $request->processo_queixa;
        $reuniao->estadoR= "Agendada";
        $reuniao->save();
 
         
        foreach ($processosSelecionados as $IDP) {
            $reuniaoProcesso = new Reuniao_Processo();
            $reuniaoProcesso->idReuniao = $reuniao->id;
        
            $getData = explode('___', $IDP);
            $reuniaoProcesso->processo = $getData[0];
            $reuniaoProcesso->tipo = $getData[1];
            $reuniaoProcesso->estado = 'Novo';
            $reuniaoProcesso->save();
        
            $processo = Processo::find($getData[0]);
            $processo->estadoP = "AGUARDANDO APRECIAÇÃO";
            $processo->save();
        }
        
        return redirect('/reunioes')->with('message', 'Reunião agendada com sucesso!');
        
    }   
         
    }
     



    public function confirmarR(Request $request){
    
        $reuniao = reuniao::find($request->id);  

        //data e hora introduzida pelo Presidente 
        $horaReuniao = $request->hora_reuniao;
        $dataReuniao = $request->data_reuniao;


        // Obter a hora atual e a data atual
        $horaAtual = date("H:i:s");
        $dataAtual = date("Y-m-d");

        // Comparar a hora atual com a hora da reunião
        if ($dataAtual > $dataReuniao){  
            return back()->with('error', 'Essa data já passou, escolha outra data!'); 
        }elseif($dataAtual == $dataReuniao && $horaAtual > $horaReuniao) {
            return back()->with('error', 'Essa hora já passou, escolha outra hora!'); 
        }else{
            $reuniao->hora_reuniao = $horaReuniao;
            $reuniao->data_reuniao = $dataReuniao;
            $reuniao->estadoR = "Confirmada";
            $reuniao->save();
            return back()->with('message', 'Reunião confirmada com sucesso.'); 
        } 
        
    }







    public function show($id)
    {
        $reuniao = Reuniao::find($id);   

        $processosSelecionados = DB::table('reuniaos')
        ->join('reuniao_processos', 'reuniaos.id', '=', 'reuniao_processos.idReuniao')
        ->join('autorizacao_registos', 'reuniao_processos.processo', '=', 'autorizacao_registos.idProcesso')
        ->select('reuniaos.*', 'reuniao_processos.*', 
        'autorizacao_registos.*',
        'autorizacao_registos.id AS IDA',
        'reuniao_processos.processo AS IDP',
        'reuniao_processos.estado AS EstadoPR',
        'reuniaos.id AS IDR',
        'reuniao_processos.estado AS estadoRP',
        'autorizacao_registos.entidade AS notificante',
        'reuniao_processos.id AS idRP') 
        ->where('reuniaos.id', '=', $id)
        ->get();
    

        if(Gate::allows('fullMenu')){ 
            return view('reunioes.show')
                ->with('reuniao',$reuniao)
                ->with('processosSelecionados',$processosSelecionados); 
        }else{
            return redirect()->back()->with('error', 'VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR ESSSA PÁGINA!'); 
        }  
    }
 



    public function gerarPdfOrdem($id)
    {
        $processosProntos = DB::table('reuniaos')
        ->join('reuniao_processos', 'reuniaos.id', '=', 'reuniao_processos.idReuniao')
        ->join('autorizacao_registos', 'reuniao_processos.processo', '=', 'autorizacao_registos.idProcesso')
        ->select('reuniaos.*', 'reuniao_processos.*', 'autorizacao_registos.*')
        ->where('reuniaos.estadoR', '=', 'Confirmada')
        ->get();

        $reuniao = Reuniao::find($id);
        $processos= Reuniao_Processo::where('idReuniao', $id)->get();
        $namePdf = date('Y-m-d H-i-s').".pdf";
        $pdf = PDF::loadView('reunioes.ordemPdf', compact('processosProntos','processos','reuniao'));  
        $pdf_content = $pdf->output(); 
        file_put_contents(public_path("reuniao/$namePdf"), $pdf_content);
        $reuniao->ordem_trab=$namePdf;
        $reuniao->save();  

        return redirect('/reunioes')->with('message','Ordem de Trabalho gerado com sucesso!');

    }



    
    public function gerarAutoFinalPdf(Request $request,$idp) {  

        
        $processosProntos = DB::table('reuniaos')
        ->join('reuniao_processos', 'reuniaos.id', '=', 'reuniao_processos.idReuniao')
        ->join('autorizacao_registos', 'reuniao_processos.processo', '=', 'autorizacao_registos.idProcesso')
        ->select('reuniaos.*', 'reuniao_processos.*', 
        'autorizacao_registos.*','autorizacao_registos.id AS IDA',
        'autorizacao_registos.entidade AS notificante',
        'reuniao_processos.id AS idRP',
        'reuniaos.id AS idR'
        )
        ->where('reuniao_processos.estado', '=', 'Novo')
        ->where('reuniao_processos.processo', '=', $idp)
        ->get();
 
        
        foreach ($processosProntos as $dados) {
            $namePdf =$dados->notificante." ". $dados->tipo ." ". date('d_m_Y_H_i_s') . ".pdf";
            $idA=$dados->IDA;
            $idRp=$dados->idRP;
            $idReu=$dados->idR;
        }
 
        $auto= AutorizacaoRegisto::find($idA); 
        $getReuniao= Reuniao_Processo::find($idRp); 
        $processo = Processo::find($idp); 
         
        if($processo->descricao_processo=="CCTV"){
            $notificacao = Videovigilancia::where('id', $processo->idForm)->get();
        } elseif($processo->descricao_processo=="Interconexao"){
            $notificacao = Interconexao::where('id', $processo->idForm)->get();
        }elseif($processo->descricao_processo=="Biometria"){
            $notificacao = Biometria::where('id', $processo->idForm)->get();
        }elseif($processo->descricao_processo=="Geral"){
            $notificacao = Geral::where('id', $processo->idForm)->get();
        }elseif($processo->descricao_processo=="GPS"){
            $notificacao = Geolocalizacao::where('id', $processo->idForm)->get();
        }elseif($processo->descricao_processo=="TIC"){
            $notificacao = Tic::where('id', $processo->idForm)->get();
        } 

        
        $pdf = PDF::loadView('processos.autoPdfFinal', compact('processo','notificacao','auto'));  
        $pdf_content = $pdf->output(); 
        file_put_contents(public_path("autos/$namePdf"), $pdf_content);
        $auto->anexo=$namePdf;
        $auto->data_decisao=date('Y-m-d');
        $auto->estado="Aprovado";
        $auto->save(); 
        $getReuniao->estado="Aprovado";
        $getReuniao->save(); 
        $processo->estadoP="PROCESSO APROVADO";
        $processo->save();  

        // Verificar se todos os processos foram "aprovado"
        $estadosAprovados = DB::table('reuniao_processos')
        ->where('idReuniao', $idReu)
        ->where('estado', '!=', 'Novo')
        ->exists();

        // Atualizar o estado da reunião para "finalizado" se todos os estados forem "aprovado"
        if (!$estadosAprovados) { 
            $r = Reuniao::find($idReu);
            $r->estadoR="Finalizada";
            $r->save();
        } 
        //LOGS DE APROVAR PROCESSO NA REUNIAO pdf
        
        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $idp;
        $log->nome_evento = $processo->tipo_processo;
        $log->action = 'Aprovação do Processo';
        $log->tipo_evento = "Processos";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();


         


        return redirect()->back()->with('message', 'Processo aprovado com sucesso. Aguardando emissão de Nota Despacho!'); 
 

    }


    public function gerarAutoFinalWord(Request $request,$idp) {  

        
        $processosProntos = DB::table('reuniaos')
        ->join('reuniao_processos', 'reuniaos.id', '=', 'reuniao_processos.idReuniao')
        ->join('autorizacao_registos', 'reuniao_processos.processo', '=', 'autorizacao_registos.idProcesso')
        ->select('reuniaos.*', 'reuniao_processos.*', 
        'autorizacao_registos.*','autorizacao_registos.id AS IDA',
        'autorizacao_registos.entidade AS notificante',
        'reuniao_processos.id AS idRP',
        'reuniaos.id AS idR'
        )
        ->where('reuniao_processos.estado', '=', 'Novo')
        ->where('reuniao_processos.processo', '=', $idp)
        ->get();
 
        
        foreach ($processosProntos as $dados) {
            $namePdf =$dados->notificante." ". $dados->tipo ." ". date('d_m_Y') . ".pdf";
            $idA=$dados->IDA;
            $idRp=$dados->idRP;
            $idReu=$dados->idR;
        }
 
        $auto= AutorizacaoRegisto::find($idA); 
        $getReuniao= Reuniao_Processo::find($idRp); 
        $processo = Processo::find($idp); 
         
        //SALVAR ANEXO NA PASTA LOCAL
        if($request->fileAuto) { 
            // caminho para salvar o anexo na pasta public/autos 
            $request->fileAuto->move(public_path('autos'), $namePdf); 
            $auto->anexo=$namePdf;
        }  
 
        $auto->data_decisao=date('Y-m-d');
        $auto->estado="Aprovado";
        $auto->save(); 
        $getReuniao->estado="Aprovado";
        $getReuniao->save(); 
        $processo->estadoP="PROCESSO APROVADO";
        $processo->save(); 

        // Verificar se todos os processos foram "aprovado"
        $estadosAprovados = DB::table('reuniao_processos')
        ->where('idReuniao', $idReu)
        ->where('estado', '!=', 'Aprovado')//antes estava Aprovado
        ->exists();

        // Atualizar o estado da reunião para "finalizado" se todos os estados forem "aprovado"
        if (!$estadosAprovados) { 
            $r = Reuniao::find($idReu);
            $r->estadoR="Finalizada";
            $r->save();
        } 
         

        //LOGS DE APROVAR PROCESSO NA REUNIAO word
        
        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $idp;
        $log->nome_evento = $processo->tipo_processo;
        $log->action = 'Aprovação do Processo';
        $log->tipo_evento = "Processos";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();

        return redirect()->back()->with('message', 'Processo aprovado com sucesso. Aguardando emissão de Nota Despacho!'); 
 

    }


    public function processoNaoAprovado(Request $request,$idr,$idp,$idRp) { 
        $reuniao = Reuniao::find($idr);   

    
        $processo = Processo::find($idp);  
        $getReuniao= Reuniao_Processo::find($idRp); 

        $getReuniao->descricao = $request->obs; 
        $getReuniao->estado="EM OBSERVAÇÃO";
        $getReuniao->save();

        $processo->estadoP = "EM OBSERVAÇÃO";
        $processo->save();


         // Verificar se todos os processos foram "aprovado"
         $estadosAprovados = DB::table('reuniao_processos')
         ->where('idReuniao', $idr)
         ->where('estado', '==', 'Novo')//antes estava Aprovado
         ->exists();
         
 
         // Atualizar o estado da reunião para "finalizado" se todos os estados forem "aprovado"
         if (!$estadosAprovados) { 
             $r = Reuniao::find($idr);
             $r->estadoR="Finalizada";
             $r->save();
         } 
         //LOGS DE NAO APROVAR PROCESSO NA REUNIAO word
         
         $log = new Log;
         $log->user_id = auth()->user()->id;
         $log->user_name = auth()->user()->name;
         $log->id_evento = $idp;
         $log->nome_evento = $processo->tipo_processo;
         $log->action = 'Não aprovação do Processo';
         $log->tipo_evento = "Processos";
         $log->ip_address = $request->ip();
         $log->user_agent = $request->userAgent();
         $log->save();

        return back()->with('message', 'Processo apreciado com sucesso. '); 
       
        
    }
    




    public function anexarAtaReuniao(Request $request,$id) {  
 
        $reuniaoAta=  Reuniao::find($id);  
        //SALVAR ANEXO NA PASTA LOCAL
        $nameFile ="Ata da Reunião ".$reuniaoAta->num_reuniao." ".date('d_m_Y')."." .$request->fileAta->extension();
        if($request->fileAta) { 
            // caminho para salvar o anexo na pasta public/atas 
            $request->fileAta->move(public_path('atas'), $nameFile); 
            $reuniaoAta->anexo_ata=$nameFile;
        }   
  
        $getLastReuniao = Reuniao::latest()->first();

        if ($getLastReuniao) {
            $numAta = $getLastReuniao['num_ata'];
            $newNumAta = explode("_", $numAta);
            //isset($newNumAta[1]) garante que a segunda posição do array $newNumAta 
            //existe antes de fazer a comparação $newNumAta[1] == date('Y')
            if (isset($newNumAta[1]) && $newNumAta[1] == date('Y')) {
                $newNum = $newNumAta[0] + 1;
                $reuniaoAta->num_ata = $newNum . "_" . date('Y');
            } else {
                $reuniaoAta->num_ata = "1_" . date('Y');
            }
        } else {
            $reuniaoAta->num_ata = "1_" . date('Y');
        }

        $reuniaoAta->estadoR = "Encerrada";
        $reuniaoAta->save(); 

        return redirect()->back()->with('message', 'Reunião encerrada. Entre em cada Processo para emitir Nota Despacho!'); 
 

    }
    



    
   
 
      
}
