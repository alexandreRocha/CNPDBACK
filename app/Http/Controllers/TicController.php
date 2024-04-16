<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tic;
use App\Models\Processo;
use App\Models\DadosContidoEmCadaRegistro;
use Illuminate\Support\Facades\Gate;
use PDF;
use Illuminate\Support\Facades\Storage;


class TicController extends Controller
{
    public function gerarPdftic($id,$idp)
    {
        $pedido = Tic::find($id);

        $dadoscontidos = DadosContidoEmCadaRegistro::where('idForm',$pedido->id)
        ->where('idForm',$pedido->id)
        ->get(); 

        $namePdf = date('Y-m-d H-i-s').".pdf";
        $pdf = PDF::loadView('tic.pdf', compact('pedido','dadoscontidos')); 
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
            $pedidos = Tic::all();
            return view('tic.index')
            ->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
    }

    public function ticnovos()
    { 
        if (Gate::allows('fullMenu')) { 
            $pedidos = Tic::where('estado', 'Novo')->get();
            return view('tic.ticnovos')->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        }
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pedidos = new Tic();
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
        $pedidos->finalidade_tratamento = $request->finalidade_tratamento;
        $pedidos->trabalhadores_abrangido_obrigacao_sigilo = $request->trabalhadores_abrangido_obrigacao_sigilo;
        $pedidos->rua_direito_acesso =$request->rua_direito_acesso;
        $pedidos->caixapostal_direito_acesso =$request->caixapostal_direito_acesso;
        $pedidos->local_direito_acesso =$request->local_direito_acesso;
        $pedidos->ilha_direito_acesso =$request->ilha_direito_acesso;
        $pedidos->concelho_direito_acesso =$request->concelho_direito_acesso;
        $pedidos->email_direito_acesso=$request->email_direito_acesso;
        $pedidos->telefone_direito_acesso=$request->telefone_direito_acesso;
        $pedidos->forma_direito_acesso=$request->forma_direito_acesso;
        $pedidos->outrasformas_direito_acesso=$request->outrasformas_direito_acesso;
        $pedidos->medidade_seguranca_fisica =$request->medidade_seguranca_fisica;
        $pedidos->medidas_seguranca_logica =$request->medidade_seguranca_fisica;
        $pedidos->regulamento_interno = $request->regulamento_interno;
        $pedidos->created_at = date('Y-m-d H:i:s');  
        $pedidos->tipo="TIC";
        $pedidos->estado="Novo"; 

        if($request->parecer_representante_trabalhadores) { 
            $nameBd = date('Y-m-d H-i-s').'.'.$request->parecer_representante_trabalhadores->extension(); 
          $capaname = $request->parecer_representante_trabalhadores->storeAs('parecerTrabalhadores',$nameBd);//renomear noime da imagem na pasta 
          $pedidos->parecer_representante_trabalhadores=$nameBd;
        } 

        if($request->regulamento_interno) { 
            $nameBd = date('Y-m-d H-i-s').'.'.$request->regulamento_interno->extension(); 
            $capaname = $request->regulamento_interno->storeAs('regulamentoInterno',$nameBd);//renomear noime da imagem na pasta 
            $pedidos->regulamento_interno=$nameBd;
         } 
   
        $pedidos->save();

          //DADOS DE DadosContidoEmCadaRegistro

          $finalidades = $request->dados_contido_em_cada_registros; 
          foreach ($finalidades as $dataF) {
              $count = count($dataF['finalidade']);
              for ($i = 0; $i < $count; $i++) {
                  $finalidade = new DadosContidoEmCadaRegistro();
                  $finalidade->categorias= $dataF['categoria'];
                  $finalidade->idForm = $pedidos->id;
                  $finalidade->finalidades = $dataF['finalidade'];
                  $finalidade->created_at = date('Y-m-d H:i:s');
      
  
  
              }
              $finalidade->save();
          }

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
            $pedido = Tic::find($id);
            $dadoscontidos = DadosContidoEmCadaRegistro::where('idForm',$id)->get();
            return view('tic.show')
            ->with('pedido',$pedido)
            ->with('dadoscontidos',$dadoscontidos);
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
