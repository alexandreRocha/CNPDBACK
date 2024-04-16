<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Support\Facades\Storage;
use App\Models\Finalidadetratamento;
use Illuminate\Support\Facades\Gate;
use App\Models\Comunicacaoterceiro;
use App\Models\Transferenciainternacional; 
use App\Models\Processo;

use App\Models\Interconexao;
use Illuminate\Http\Request;

class InterconexaoController extends Controller
{
    public function gerarPdfinter($id,$idp)
    { 
         
        $pedido = Interconexao::find($id);   

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
        $pdf = PDF::loadView('interconexao.pdf', compact('pedido','transferencia','comunicacao','finalidades')); 
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
            $pedidos = Interconexao::all();
            return view('interconexao.index')->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
        
    }

    public function internovos()
    { 
        if (Gate::allows('fullMenu')) { 
            $pedidos = Interconexao::where('estado', 'Novo')->get();
            return view('interconexao.internovos')->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
        
    }


    public function create(Request $request)
    {
        $pedidos = new Interconexao();
        $pedidos->created_at = date('Y-m-d H:i:s');
        $pedidos->tipo_notificacao = $request->tipo_notificacao;
        $pedidos->tipo_pessoa = $request->tipo_pessoa;
        $pedidos->nome_denominacao = $request->nome_denominacao;
        $pedidos->nome_comercial = $request->nome_comercial;
        $pedidos->atividade_desenvolvida = $request->atividade_desenvolvida;
        $pedidos->numero_nif = $request->numero_nif;
        $pedidos->rua_responsavel_tratamento =
            $request->rua_responsavel_tratamento;
        $pedidos->local_responsavel_tratamento =
            $request->local_responsavel_tratamento;
        $pedidos->ilha_responsavel_tratamento =
            $request->ilha_responsavel_tratamento;
        $pedidos->concelho_responsavel_tratamento =
            $request->concelho_responsavel_tratamento;
        $pedidos->caixapostal_responsavel_tratamento =
            $request->caixapostal_responsavel_tratamento;
        $pedidos->contato_responsavel_tratamento =
            $request->contato_responsavel_tratamento;
        $pedidos->email_responsavel_tratamento =
            $request->email_responsavel_tratamento;
        $pedidos->pais_responsavel_tratamento =
            $request->pais_responsavel_tratamento;
        $pedidos->nome_representante_instalacao =
            $request->nome_representante_instalacao;
        $pedidos->rua_representante_instalacao =
            $request->rua_representante_instalacao;
        $pedidos->caixapostal_representante_instalacao =
            $request->caixapostal_representante_instalacao;
        $pedidos->local_representante_instalacao =
            $request->local_representante_instalacao;
        $pedidos->ilha_representante_instalacao =
            $request->ilha_representante_instalacao;
        $pedidos->concelho_representante_instalacao =
            $request->concelho_representante_instalacao;
        $pedidos->nome_pessoa_contato_representante_instalacao =
            $request->nome_pessoa_contato_representante_instalacao;
        $pedidos->email_pessoa_representante_instalacao =
            $request->email_pessoa_representante_instalacao;
        $pedidos->contato_representante_instalacao =
            $request->contato_representante_instalacao;
        $pedidos->entidade_processamento_informacao =
            $request->entidade_processamento_informacao;
        $pedidos->rua_processamento_informacao =
            $request->rua_processamento_informacao;
        $pedidos->caixapostal_processamento_informacao =
            $request->caixapostal_processamento_informacao;
        $pedidos->local_processamento_informacao =
            $request->local_processamento_informacao;
        $pedidos->ilha_processamento_informacao =
            $request->ilha_processamento_informacao;
        $pedidos->concelho_processamento_informacao =
            $request->concelho_processamento_informacao;
        $pedidos->tipo_pessoaSR = $request->tipo_pessoaSR;
        $pedidos->nome_denominacaoSR = $request->nome_denominacaoSR;
        $pedidos->nome_comercialSR = $request->nome_comercialSR;
        $pedidos->atividade_desenvolvidaSR = $request->atividade_desenvolvidaSR;
        $pedidos->numero_nifSR = $request->numero_nifSR;
        $pedidos->rua_responsavel_tratamentoSR =
            $request->rua_responsavel_tratamentoSR;
        $pedidos->local_responsavel_tratamentoSR =
            $request->local_responsavel_tratamentoSR;
        $pedidos->ilha_responsavel_tratamentoSR =
            $request->ilha_responsavel_tratamentoSR;
        $pedidos->concelho_responsavel_tratamentoSR =
            $request->concelho_responsavel_tratamentoSR;
        $pedidos->caixapostal_responsavel_tratamentoSR =
            $request->caixapostal_responsavel_tratamentoSR;
        $pedidos->contato_responsavel_tratamentoSR =
            $request->contato_responsavel_tratamentoSR;
        $pedidos->email_responsavel_tratamentoSR =
            $request->email_responsavel_tratamentoSR;
        $pedidos->pais_responsavel_tratamentoSR =
            $request->pais_responsavel_tratamentoSR;
        $pedidos->nome_representante_instalacaoSR =
            $request->nome_representante_instalacaoSR;
        $pedidos->rua_representante_instalacaoSR =
            $request->rua_representante_instalacaoSR;
        $pedidos->caixapostal_representante_instalacaoSR =
            $request->caixapostal_representante_instalacaoSR;
        $pedidos->local_representante_instalacaoSR =
            $request->local_representante_instalacaoSR;
        $pedidos->ilha_representante_instalacaoSR =
            $request->ilha_representante_instalacaoSR;
        $pedidos->concelho_representante_instalacaoSR =
            $request->concelho_representante_instalacaoSR;
        $pedidos->nome_pessoa_contato_representante_instalacaoSR =
            $request->nome_pessoa_contato_representante_instalacaoSR;
        $pedidos->email_pessoa_representante_instalacaoSR =
            $request->email_pessoa_representante_instalacaoSR;
        $pedidos->contato_representante_instalacaoSR =
            $request->contato_representante_instalacaoSR;
        $pedidos->entidade_processamento_informacaoSR =
            $request->entidade_processamento_informacaoSR;
        $pedidos->rua_processamento_informacaoSR =
            $request->rua_processamento_informacaoSR;
        $pedidos->caixapostal_processamento_informacaoSR =
            $request->caixapostal_processamento_informacaoSR;
        $pedidos->local_processamento_informacaoSR =
            $request->local_processamento_informacaoSR;
        $pedidos->ilha_processamento_informacaoSR =
            $request->ilha_processamento_informacaoSR;
        $pedidos->concelho_processamento_informacaoSR =
            $request->concelho_processamento_informacaoSR;
        $pedidos->descricao_forma_interconexao =
            $request->descricao_forma_interconexao; 
        $pedidos->pais_representante_instalacao = 'Cabo verde';
        $pedidos->pais_representante_instalacaoSR = 'Cabo verde';
        $pedidos->outraFinalidadeTratamento =  $request->outraFinalidadeTratamento;
        $pedidos->dados_pessoais_tratado=$request->dados_pessoais_tratado;
        $pedidos->outros_dados_art8e11=$request->outros_dados_art8e11;
        $pedidos->listadados_pessoais_tratados=$request->listadados_pessoais_tratados;
        $pedidos->prazo_conservacao_dados=$request->prazo_conservacao_dados;
        $pedidos->rua_direito_acesso=$request->rua_direito_acesso;
        $pedidos->caixapostal_direito_acesso=$request->caixapostal_direito_acesso;
        $pedidos->local_direito_acesso=$request->local_direito_acesso;
        $pedidos->ilha_direito_acesso=$request->ilha_direito_acesso;
        $pedidos->concelho_direito_acesso=$request->concelho_direito_acesso;
        $pedidos->email_direito_acesso=$request->email_direito_acesso;
        $pedidos->contato_direito_acesso=$request->contato_direito_acesso;
        $pedidos->forma_direito_acesso=$request->forma_direito_acesso;
        $pedidos->outraforma_direito_acesso=$request->outraforma_direito_acesso;
        $pedidos->medidas_fisicas_seguranca=$request->medidas_fisicas_seguranca;
        $pedidos->medidas_logicas_seguranca=$request->medidas_logicas_seguranca;
        $pedidos->estado="Novo";
        $pedidos->tipo="Interconexao";
        
        $pedidos->save();

        if($request->array_finalidades){
            //DADOS DE FINALIDADES TRATADOS
            $finalidades = $request->array_finalidades; 
            foreach ($finalidades as $dataF) {
                $count = count($dataF['finalidade']);
                for ($i = 0; $i < $count; $i++) {
                    $finalidade = new Finalidadetratamento();
                    $finalidade->categorias_finalidade = $dataF['categoria'];
                    $finalidade->finalidades = $dataF['finalidade'];
                    $finalidade->tipoform = 'Interconexao';
                    $finalidade->idForm = $pedidos->id;
                    $finalidade->created_at = date('Y-m-d H:i:s'); 
                }
                $finalidade->save();
            }
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
                    $comunicacao->dados_transferidos = ""; 
                    $comunicacao->idForm = $pedidos->id;
                    $comunicacao->tipoform = 'Interconexao';
                    $comunicacao->created_at = date('Y-m-d H:i:s');

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
                    $transferencia->entidades = $dataC['paisTransferido'];
                    $transferencia->pais = $dataC['paisTransferido'];
                    $transferencia->dados_transferidos = $dataC['dadosTransferidos'];
                    $transferencia->fundamento = "";
                    $transferencia->idForm = $pedidos->id;
                    $transferencia->tipoform = 'Interconexao';
                    $transferencia->created_at = date('Y-m-d H:i:s');
            }
                $transferencia->save();
            }
        }  

      

        return response()->json(['message' => 'Dados submetidos com sucesso!']);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        if (Gate::allows('fullMenu')) { 
            $pedido = Interconexao::find($id);
            $finalidades = Finalidadetratamento::where('idForm',$id)
            ->where('tipoform',$pedido->tipo)
            ->get();
            $comunicacao = Comunicacaoterceiro::where('idForm',$id)->get();
            $transferencia = Transferenciainternacional::where('idForm',$id)->get();
            return view('interconexao.show')
            ->with('pedido',$pedido)
            ->with('finalidades',$finalidades)
            ->with('transferencia',$transferencia)
            ->with('comunicacao',$comunicacao);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
        
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //$reuest = new Request()
    }

    public function destroy($id)
    {
        //
    }
}
