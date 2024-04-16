<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Models\Geral;
use App\Models\Processo;
use App\Models\Finalidadetratamento;
use App\Models\Comunicacaoterceiro;
use App\Models\Transferenciainternacional;  


class GeralController extends Controller
{
    public function gerarPdfgeral($id,$idp)
    { 
         
        $pedido = Geral::find($id);   
        $finalidades = Finalidadetratamento::where('idForm',$id)
        ->where('tipoform',$pedido->tipo)
        ->get();
 
        $comunicacao = Comunicacaoterceiro::where('idForm',$pedido->id)
        ->where('tipoform',$pedido->tipo)
        ->get(); 
        $transferencia = Transferenciainternacional::where('idForm',$pedido->id)
        ->where('tipoform',$pedido->tipo)
        ->get(); 
 
        $namePdf=date('Y-m-d H-i-s').".pdf";
        $pdf = PDF::loadView('geral.pdf', compact('pedido','transferencia','comunicacao','finalidades'));  
        $pdf_content = $pdf->output();
        Storage::put("formularios/$namePdf", $pdf_content);

        $processo = Processo::find($idp);
        $processo->anexo_forms = $namePdf;  
        $processo->save();
        
        return back()->with('message','PDF gerado com sucesso!');
    }

    
    public function index()
    {
        if (Gate::allows('fullMenu')) { 
            $pedidos = Geral::all();
            return view('geral.index')->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
        
    }



    public function geralnovos()
    { 
        if (Gate::allows('fullMenu')) { 
            $pedidos = Geral::where('estado', 'Novo')->get();
            return view('geral.geralnovos')->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
        
    }
    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $pedidos = new Geral();
        $pedidos->tipo_notificacao=$request->tipo_notificacao;
        $pedidos->tipo_pessoa=$request->tipo_pessoa;
        $pedidos->nome_denominacao=$request->nome_denominacao;
        $pedidos->nome_comercial=$request->nome_comercial;
        $pedidos->atividade_desenvolvida=$request->atividade_desenvolvida;
        $pedidos->numero_nif=$request->numero_nif;
        $pedidos->rua_responsavel_tratamento=$request->rua_responsavel_tratamento;
        $pedidos->local_responsavel_tratamento=$request->local_responsavel_tratamento;
        $pedidos->ilha_responsavel_tratamento=$request->ilha_responsavel_tratamento;
        $pedidos->concelho_responsavel_tratamento=$request->concelho_responsavel_tratamento;
        $pedidos->caixapostal_responsavel_tratamento=$request->caixapostal_responsavel_tratamento;
        $pedidos->telefone_responsavel_tratamento=$request->telefone_responsavel_tratamento;
        $pedidos->email_responsavel_tratamento=$request->email_responsavel_tratamento;
        $pedidos->pais_responsavel_tratamento=$request->pais_responsavel_tratamento;
        $pedidos->nome_representante_tratamento=$request->nome_representante_tratamento;
        $pedidos->rua_representante_tratamento=$request->rua_representante_tratamento;
        $pedidos->caixapostal_representante_tratamento=$request->caixapostal_representante_tratamento;
        $pedidos->local_representante_tratamento=$request->local_representante_tratamento;
        $pedidos->ilha_representante_tratamento=$request->ilha_representante_tratamento;
        $pedidos->concelho_representante_tratamento=$request->concelho_representante_tratamento;
        $pedidos->nome_pessoa_contato=$request->nome_pessoa_contato;
        $pedidos->email_representante_tratamento=$request->email_representante_tratamento;
        $pedidos->telefone_representante_tratamento=$request->telefone_representante_tratamento;
        $pedidos->entidade_processamento_informacao=$request->entidade_processamento_informacao;
        $pedidos->rua_entidade_processamento=$request->rua_entidade_processamento;
        $pedidos->caixapostal_entidade_processamento=$request->caixapostal_entidade_processamento;
        $pedidos->local_entidade_processamento=$request->local_entidade_processamento;
        $pedidos->ilha_entidade_processamento=$request->ilha_entidade_processamento;
        $pedidos->concelho_entidade_processamento=$request->concelho_entidade_processamento;
        $pedidos->outraFinalidadeTratamento =  $request->outraFinalidadeTratamento;
        $pedidos->dados_pessoais_contidos = $request->dados_pessoais_contidos; 
        $pedidos->outros_dados_tratados_8_11 =$request->outros_dados_tratados_8_11;
        $pedidos->lista_dados_pessoais_tratados =$request->lista_dados_pessoais_tratados;
        $pedidos->recolha_direta =$request->recolha_direta;
        $pedidos->url_recolha =$request->url_recolha;
        $pedidos->descricao_outra_forma_recolhadireta =$request->descricao_outra_forma_recolhadireta;
        $pedidos->recolha_indireta =$request->recolha_indireta;
        $pedidos->descricao_finalidade_interconexao =$request->descricao_finalidade_interconexao;
        $pedidos->prazo_maximo_conservacao =$request->prazo_maximo_conservacao;
        $pedidos->rua_direito_acesso =$request->rua_direito_acesso;
        $pedidos->caixapostal_direito_acesso =$request->caixapostal_direito_acesso;
        $pedidos->local_direito_acesso =$request->local_direito_acesso;
        $pedidos->ilha_direito_acesso =$request->ilha_direito_acesso;
        $pedidos->concelho_direito_acesso =$request->concelho_direito_acesso;
        $pedidos->email_direito_acesso=$request->email_direito_acesso;
        $pedidos->telefone_direito_acesso=$request->telefone_direito_acesso;
        $pedidos->forma_direito_acesso=$request->forma_direito_acesso;
        $pedidos->outrasformas_direito_acesso=$request->outrasformas_direito_acesso;
        $pedidos->medidade_seguranca_fisica=$request->medidade_seguranca_fisica;
        $pedidos->medidas_seguranca_logica=$request->medidas_seguranca_logica;
        $pedidos->estado="Novo";
        $pedidos->tipo="Geral";
        $pedidos->created_at = date('Y-m-d H:i:s');
        
       
        if($request->parecer_representante_trabalhadores) { 
            $nameBd=date('Y-m-d H-i-s').'.'.$request->parecer_representante_trabalhadores->extension(); 
          $capaname = $request->parecer_representante_trabalhadores->storeAs('parecerTrabalhadores',$nameBd);//renomear noime da imagem na pasta 
          $pedidos->parecer_representante_trabalhadores=$nameBd;
        } 
        
        $pedidos->save();

      
                    
        //DADOS DE FINALIDADES TRATADOS

     $finalidades = $request->array_finalidades; 
        foreach ($finalidades as $dataF) {
            $count = count($dataF['finalidade']);
            for ($i = 0; $i < $count; $i++) {
                $finalidade = new Finalidadetratamento();
                $finalidade->categorias_finalidade = $dataF['categoria']; 
                $finalidade->idForm = $pedidos->id;
                $finalidade->finalidades = $dataF['finalidade'];  
                $finalidade->created_at = date('Y-m-d H:i:s');
                $finalidade->tipoform = 'Geral';
               
            }
            
            $finalidade->save();
        }
       
    if($request->array_comunicacao_terceiros){ 
            // DADOS DE COMUNICACAO A TERCEIROS 
            $comunicacao_terceiros = $request->array_comunicacao_terceiros; 
            foreach ($comunicacao_terceiros as $dataC) {
                $count = count( $comunicacao_terceiros);
                for ($i = 0; $i < $count; $i++) {
                    $comunicacao = new Comunicacaoterceiro();
                    $comunicacao->entidades_comunicadas = $dataC['entidadesComunicadas'];
                    $comunicacao->condicoes_comunicacao = $dataC['condicoesComunicacao'];
                    $comunicacao->dados_transferidos = $dataC['dadosTransferidos'];
                    $comunicacao->idForm = $pedidos->id;
                    $comunicacao->created_at = date('Y-m-d H:i:s');
                    $comunicacao->tipoform = 'Geral';
                    
                   
            }
                $comunicacao->save();
            }  
       }
  
        //DADOS DE TRANSFERENCIAS INTERNACIONAIS
        
     if($request->array_transferencia_internacional){
        $transfInternacional = $request->array_transferencia_internacional; 
        foreach ($transfInternacional as $dataC) {
            $count1 = count( $transfInternacional);
            for ($i = 0; $i < $count1; $i++) {
                $transferencia = new Transferenciainternacional();
                $transferencia->entidades = $dataC['entidadesInternacional'];
                $transferencia->pais = $dataC['paisTransferido'];
                $transferencia->dados_transferidos = $dataC['dadosTransferidosInt'];
                $transferencia->fundamento  = $dataC['fundamento'];
                $transferencia->idForm = $pedidos->id;
                $transferencia->created_at = date('Y-m-d H:i:s');
                $transferencia->tipoform = 'Geral';
            
        }
            $transferencia->save();
        }
    } 
    
        return response()->json([
            "message" => "Sua mensagem foi enviada para o Central de Apoio da CNPD!"
        ], 201);


        
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        if (Gate::allows('fullMenu')) { 
            $pedido = Geral::find($id);
            $finalidades = Finalidadetratamento::where('idForm',$id)
            ->where('tipoform',$pedido->tipo)
            ->get();

            $comunicacao = Comunicacaoterceiro::where('idForm',$id)
            ->where('tipoform',$pedido->tipo)
            ->get();
            
            $transferencia = Transferenciainternacional::where('idForm',$id)
            ->where('tipoform',$pedido->tipo)
            ->get(); 

            return view('geral.show')
            ->with('pedido',$pedido)
            ->with('finalidades',$finalidades)
            ->with('transferencia',$transferencia)
            ->with('comunicacao',$comunicacao) ;
        
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}