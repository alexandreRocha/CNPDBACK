<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Models\Geolocalizacao;
use App\Models\Processo;
use Illuminate\Http\Request;

class GeolocalizacaoController extends Controller
{
    public function gerarPDFgps($id,$idp)
    {
        $pedido = Geolocalizacao::find($id);
        $namePdf=date('Y-m-d H-i-s').".pdf";
        $pdf = PDF::loadView('geolocalizacao.pdf', compact('pedido')); 
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
            $pedidos = Geolocalizacao::all();
            return view('geolocalizacao.index')->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
        
    }

    public function geonovos()
    { 
        if (Gate::allows('fullMenu')) { 
            $pedidos = Geolocalizacao::where('estado', 'Novo')->get();
            return view('geolocalizacao.geonovos')->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
        
    }


    public function create(Request $request)
    {
        $pedidos= new Geolocalizacao();

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
        $pedidos->nome_representante_instalacao=$request->nome_representante_instalacao;
        $pedidos->rua_representante_instalacao=$request->rua_representante_instalacao;
        $pedidos->caixapostal_representante_instalacao=$request->caixapostal_representante_instalacao;
        $pedidos->local_representante_instalacao=$request->local_representante_instalacao;
        $pedidos->ilha_representante_instalacao=$request->ilha_representante_instalacao;
        $pedidos->concelho_representante_instalacao=$request->concelho_representante_instalacao;
        $pedidos->nome_pessoa_contato_representante_instalacao=$request->nome_pessoa_contato_representante_instalacao;
        $pedidos->email_pessoa_representante_instalacao=$request->email_pessoa_representante_instalacao;
        $pedidos->contato_representante_instalacao=$request->contato_representante_instalacao;
        $pedidos->entidade_processamento_informacao=$request->entidade_processamento_informacao;
        $pedidos->rua_processamento_informacao=$request->rua_processamento_informacao;
        $pedidos->caixapostal_processamento_informacao=$request->caixapostal_processamento_informacao;
        $pedidos->local_processamento_informacao=$request->local_processamento_informacao;
        $pedidos->ilha_processamento_informacao=$request->ilha_processamento_informacao;
        $pedidos->concelho_processamento_informacao=$request->concelho_processamento_informacao;
        $pedidos->finalidade_tratamento=$request->finalidadeTratamento;
        $pedidos->categoria_dados=$request->categoriaDados;
        $pedidos->outros_dados=$request->outrosDados;

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
        if($request->parecer_representante_trabalhadores) { 
            $nameBd=date('Y-m-d H-i-s').'.'.$request->parecer_representante_trabalhadores->extension(); 
          $capaname = $request->parecer_representante_trabalhadores->storeAs('parecerTrabalhadores',$nameBd);//renomear noime da imagem na pasta 
          $pedidos->parecer_representante_trabalhadores=$nameBd;
        }    
        $pedidos->estado="Novo";
        $pedidos->tipo="GPS";
        $pedidos->created_at=date('Y-m-d H:i:s');
        $pedidos->save();

      return response()->json(["message" => "Dados submetidos com sucesso!"]);
    }


    public function show($id)
    {
        if (Gate::allows('fullMenu')) { 
            $pedido = Geolocalizacao::find($id);
            return view('geolocalizacao.show')->with('pedido',$pedido);
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
        //
    }


    public function destroy($id)
    {
        //
    }
}
