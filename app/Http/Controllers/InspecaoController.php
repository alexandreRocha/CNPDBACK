<?php

namespace App\Http\Controllers;

use App\Models\Inspecao;
use App\Models\Inspefotos;
use App\Models\Processo;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use PDF;

class InspecaoController extends Controller
{
     
    public function index()
    {
        $inspecaos = Inspecao::orderBy('created_at')->get(); 
        return view('inspecoes.index')->with('inspecaos',$inspecaos);  
    } 
    public function minhasInspecoes(){
        if (Auth::check()) {
            $minhasinsp = Inspecao::where('equipa_insp', Auth::user()->name)->get();
            $contsMeus=count($minhasinsp); 
            return view('inspecoes.minhasInspecoes', compact('minhasinsp','minhasinsp')); 
        
        }else{
             //abort(403);
             return back()->with('alerta','Sem permisão!');
        }
    }


 
    public function realizarInspecoes(Request $request)
    { 
       $processo = Processo::find($request->id); 
       $inspecao = new Inspecao();

       //log de inspecao

       $log = new Log;
       $log->user_id = auth()->user()->id;
       $log->user_name = auth()->user()->name;
       $log->id_evento = $processo->id;
       $log->nome_evento = $processo->entidade;
       $log->action = 'Realizar inspeção';
       $log->tipo_evento = "Processos";
       $log->ip_address = $request->ip();
       $log->user_agent = $request->userAgent();
       $log->save();


       $inspecao->entidade=$request->entidade;
       $inspecao->created_at=$request->created_at;
       $inspecao->horai=$request->horai;
       $inspecao->horaf=$request->horaf;
       $inspecao->receb_por_funcao=$request->receb_por_funcao;
       $inspecao->local=$request->local;  
       $inspecao->num_camara=$request->num_camara;
       $inspecao->cam_funcio=$request->cam_funcio;
       $inspecao->quem_visualtemp=$request->quem_visualtemp;
       $inspecao->transm_fora=$request->transm_fora;
       $inspecao->som=$request->som;
       $inspecao->aviso=$request->aviso;  
       $inspecao->tempo_conserv=$request->tempo_conserv;
       $inspecao->serv_grav=$request->serv_grav;
       $inspecao->medid_log=$request->medid_log;
       $inspecao->entidd_extern=$request->entidd_extern;
       $inspecao->mais_obs=$request->mais_obs;
       $inspecao->equipa_insp=Auth::user()->name; 
       $inspecao->finalidade=$request->finalidade; 
       $inspecao->id_processo=$request->id;
       $inspecao->localiz_cam=$request->localiz_cam; 
       $inspecao->tipo_insp=$request->tipo_insp;
       $inspecao->estado="Realizada";
       
       
      $inspecao->save();


       return back()->with('message', 'Inspeção realizada com sucesso! Agora precisas gerar o relatório.'); 
    }


 

    







     
    public function show($id)
    {  
        $inspecaoId = Inspecao::find($id);  
        if(!$inspecaoId){
            return redirect()->back()->with('error', 'ESTA DECISÃO NÃO EXISTE!'); 
        } 

        $fotos=Inspefotos::where('idInspecao', $inspecaoId->id)->get(); 

        $minhasinsp=Inspecao::where('id', $inspecaoId->id)
        ->where('equipa_insp',Auth::user()->name)->get(); 

        if(Gate::allows('fullMenu') || count($minhasinsp) > 0 && $minhasinsp[0]->equipa_insp == Auth::user()->name){
            return view('inspecoes.show')
            ->with('inspecaoId',$inspecaoId)
            ->with('fotos',$fotos); 
        }else{
            return redirect()->back()->with('error', 'VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR ESSA INSPEÇÃO!'); 
        }  
    }









      

    public function addFotografia(Request $request,$id)
    {
        $foto = new Inspefotos(); 

        $foto->idInspecao=$id;  
        if($request->anexoFoto) { 
          $nameBd=date('Y-m-d H-i-s').'.'.$request->anexoFoto->extension();  
          $request->anexoFoto->move(public_path('inspecoesProcesso'), $nameBd);
          $foto->anexo=$nameBd;
        }     
        $foto->created_at=date('Y-m-d H:i:s');
        $foto->estado="Novo";
        $foto->save();

        return back()->with('message','Anexo submetido com sucesso!');
    }
  










    public function gerarReportInsp($id)
    {
        $report = Inspecao::find($id);
        $fotos=Inspefotos::where('idInspecao', $report->id)->get(); 

        $namePdf="Relatorio Inspecao ".$report->entidade."_".date('H_i_s').".pdf";  
        $pdf = PDF::loadView('inspecoes.report', compact('report','fotos'));  
        $pdf_content = $pdf->output(); 
        file_put_contents(public_path("inspecoesProcesso/$namePdf"), $pdf_content);
        $report->anexo_rel=$namePdf;
        $report->estado="Concluido";
        $report->save(); 
          
        return back()->with('message','Relatório Inspeção gerado com sucesso!');
    }




    
    public function store(Request $request)
    {
        //
    }

  
 
    public function edit(Inspecao $inspecao)
    {
        //
    }

     
    public function update(Request $request, Inspecao $inspecao)
    {
        //
    }
 
    public function destroy(Inspecao $inspecao)
    {
        //
    }
}
