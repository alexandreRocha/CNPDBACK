<?php

namespace App\Http\Controllers;

use App\Models\AutorizacaoRegisto;
use App\Models\Processo;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\Log;


class AutorizacaoRegistoController extends Controller
{
     
    public function index()
    {
        if (Gate::allows('fullMenu')) { 
            $auto=AutorizacaoRegisto::all(); 
            return view('autorizacaoregisto.index')->with('auto',$auto); 
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
    } 
    public function minhasAuto()
    {
        if (Auth::check()) {
            $minhasAuto = Processo::join('autorizacao_registos', 'autorizacao_registos.idProcesso', '=', 'processos.id')
            ->where('responsavel_processo', Auth::user()->name)
            ->get(); 
            return view('autorizacaoregisto.minhasAuto', compact('minhasAuto')); 
        }else{
             //abort(403);
             return back()->with('alerta','Sem permisão!');
        }
        
    } 









    public function anexarAuto(Request $request)
    {
        $autoDoc = new AutorizacaoRegisto();
        $processo = Processo::find($request->id); 
        $autoDoc->tipo_entidade=$processo->descricao_processo;
        $autoDoc->tipo_processo=$processo->tipo_processo;

        
          //VALIDAR O NUMERO DE DECISAO 
        if($processo->tipo_processo=="Autorizacao"){   
            $ultimoAuto = AutorizacaoRegisto::where('num_decisao', 'LIKE', '%/A%')
            ->orderBy('id', 'desc')
            ->first();

            if($ultimoAuto){
                $numDoc = $ultimoAuto['num_decisao'];
                $newNumAut=explode("/",$numDoc); //1/2023_A
    
                if($newNumAut[1]==date('Y')){//ultimo num doc e de 2023
                    $newNum= $newNumAut[0]+1;
                    $autoDoc->num_decisao =$newNum."/".date('Y')."/A";
                }else{ //ultimo num doc e de ano anterior
                     $autoDoc->num_decisao ="1/".date('Y')."/A";
                }  
            }else{
                $autoDoc->num_decisao ="1/".date('Y')."/A";
            }
        }elseif($processo->tipo_processo=="Registo"){
            $ultimoReg = AutorizacaoRegisto::where('num_decisao', 'LIKE', '%/R%')
            ->orderBy('id', 'desc')
            ->first();
            if($ultimoReg){
                $numDoc = $ultimoReg['num_decisao'];
                $newNumReg=explode("/",$numDoc); //1/2023_R
                
    
                if($newNumReg[1]==date('Y')){//ultimo num doc e de 2023
                    $newNum= $newNumReg[0]+1;
                    $autoDoc->num_decisao =$newNum."/".date('Y')."/R";
                }else{//ultimo num doc e de ano anterior
                     $autoDoc->num_decisao ="1/".date('Y')."/R";
                }  
            }else{
                $autoDoc->num_decisao ="1/".date('Y')."/R";
            }
        }  

        $autoDoc->entidade=$processo->entidade;
        $autoDoc->idProcesso=$request->id; 

        //SALVAR ANEXO NA PASTA LOCAL
        if($request->fileAuto) { 
          $nameBd=$processo->entidade."_".date('Y-m-d H_i_s').'.'.$request->fileAuto->extension();  
           // caminho para salvar o anexo na pasta public/autos 
          $request->fileAuto->move(public_path('autos'), $nameBd);
          $autoDoc->anexo=$nameBd;
        }   

        $autoDoc->created_at=date('Y-m-d H:i:s');
        $autoDoc->estado="AUTORIZAÇÃO EMITIDA"; 
        $autoDoc->data_decisao="";  

         //log de submissao de decisao

         $log = new Log;
         $log->user_id = auth()->user()->id;
         $log->user_name = auth()->user()->name;
         $log->id_evento = $processo->id;
         $log->nome_evento = $autoDoc->entidade;
         $log->action = 'Anexar decisão';
         $log->tipo_evento = "Processos";
         $log->ip_address = $request->ip();
         $log->user_agent = $request->userAgent();
         $log->save();
        
        //USER TIPO TECNICO
        if(Auth::user()->typeUser=="Informatico" || Auth::user()->typeUser=="Jurista"){ 
            if($processo->tipo_processo=="Autorizacao"){ 
                $autoDoc->estado="AUTORIZAÇÃO EMITIDA PELO TÉCNICO"; 
                $autoDoc->save();
                $processo->estadoP="AUTORIZAÇÃO EMITIDA PELO TÉCNICO";
                $processo->save();
                return back()->with('message','Autorização gerado com sucesso!'); 
            }elseif($processo->tipo_processo=="Registo"){
                $autoDoc->estado="REGISTO EMITIDO PELO TÉCNICO"; 
                $autoDoc->save();
                $processo->estadoP="REGISTO EMITIDO PELO TÉCNICO";
                $processo->save(); 
                return back()->with('message','Registo gerado com sucesso!');
            } 

        //USER TIPO MEMBRO
        }elseif(Auth::user()->typeUser=="Membro"){ 
            if($processo->tipo_processo=="Autorizacao"){ 
                $autoDoc->estado="AUTORIZAÇÃO EMITIDA PELO MEMBRO"; 
                $autoDoc->save();
                $processo->estadoP="AUTORIZAÇÃO EMITIDA PELO MEMBRO";
                $processo->save();
                return back()->with('message','Autorização gerado com sucesso!'); 
            }elseif($processo->tipo_processo=="Registo"){
                $autoDoc->estado="REGISTO EMITIDO PELO MEMBRO"; 
                $autoDoc->save();
                $processo->estadoP="REGISTO EMITIDO PELO MEMBRO";
                $processo->save(); 
                return back()->with('message','Registo gerado com sucesso!');
            }  
        }
         //log de submissao de decisao

       $log = new Log;
       $log->user_id = auth()->user()->id;
       $log->user_name = auth()->user()->name;
       $log->id_evento = $processo->id;
       $log->nome_evento = $autoDoc->entidade;
       $log->action = 'Anexar decisão';
       $log->tipo_evento = "Processos";
       $log->ip_address = $request->ip();
       $log->user_agent = $request->userAgent();
       $log->save();

    }
  





 







 
     
    public function show($id)
    {  
        $autoid = AutorizacaoRegisto::find($id);  
        if(!$autoid){
            return redirect()->back()->with('error', 'ESTA DECISÃO NÃO EXISTE!'); 
        }
        $minhasAuto = DB::table('autorizacao_registos')
        ->join('processos', 'autorizacao_registos.idProcesso', '=', 'processos.id')
        ->where('autorizacao_registos.id', $autoid->id)
        ->where('processos.responsavel_processo', '=', Auth::user()->name)
        ->get(); 

        if(Gate::allows('fullMenu') || count($minhasAuto) > 0 && $minhasAuto[0]->responsavel_processo == Auth::user()->name){
            return view('autorizacaoregisto.show')->with('autoid',$autoid); 
        }else{
            return redirect()->back()->with('error', 'VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR ESSA DECISÃO!'); 
        }  
    }
 
    public function ListarAutos()
    {  
        $estado="Aprovado";
        return AutorizacaoRegisto::where(['tipo_processo'=>"Autorizacao",'estado'=>$estado])->orderBy('id', 'DESC')->get();
    } 

    public function ListarRegistos()
    {  
        $estado="Aprovado";
        return AutorizacaoRegisto::where(['tipo_processo'=>"Registo",'estado'=>$estado])->orderBy('id', 'DESC')->get();
    } 
    public function AutoId($id)
    {
        $pubs = AutorizacaoRegisto::find($id); 
        return response($pubs,200);
    } 

    
}
