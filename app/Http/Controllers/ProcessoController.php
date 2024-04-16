<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Processo;
use App\Models\DocProcesso;
use App\Models\Videovigilancia;
use App\Models\Interconexao;
use App\Models\Biometria;
use App\Models\Geral;
use App\Models\Tic;
use App\Models\Geolocalizacao;
use App\Models\AutorizacaoRegisto;
use App\Models\Inspecao;
use App\Models\Log;
use App\Models\Comment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Mail;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;  
use Illuminate\Support\Facades\File;


class ProcessoController extends Controller
{ 



    public function index()
    {
        if (Gate::allows('fullMenu')) { 
            $processos = Processo::orderBy('id')->get(); 
            return view('processos.index')->with('processos',$processos); 
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
    } 

    public function meusProcessos(){
        if (Auth::check()) {
            $processos = Processo::where('responsavel_processo', Auth::user()->name)->get();
            return view('processos.meusProcessos', compact('processos')); 
        }else{
             //abort(403);
             return back()->with('alerta','Sem permisão!');
        }
    }

    public function enviadosaMim(){
        $processos = Processo::where('responsavel_processo', Auth::user()->name)
            ->where(function ($query) {
                $query->where('estadoP', 'EM ANÁLISE PELO TÉCNICO')
                    ->orWhere('estadoP', 'EM ANÁLISE PELO MEMBRO');
            })->get(); 
        return view('processos.enviadosaMim', compact('processos')); 
    }

    public function aguardarNotaD(){
        $processos = Processo::where('estadoP', "PROCESSO APROVADO")->get(); 
        return view('processos.aguardarNotas', compact('processos')); 
    }

    public function prontoEnvioAN(){
        $processos = Processo::where('estadoP', "CONCLUIDO")->get(); 
        return view('processos.prontoEnvio', compact('processos')); 
    }

    public function paProvacao(){
        $processos = Processo::where('estadoP', 'AGUARDANDO APROVAÇÃO')->get(); 
        return view('processos.paprovacao', compact('processos')); 
    } 

    public function notificarSecPaprov(){ 
        
        if(Auth::user()->typeUser=="Membro"){
            $processos = Processo::where(function($query) {
                $query->where('estadoP', 'AUTORIZAÇÃO EMITIDA PELO MEMBRO')
                      ->orWhere('estadoP', 'REGISTO EMITIDO PELO MEMBRO');
            })
            ->where('responsavel_processo', Auth::user()->name)
            ->get(); 
        }else{
            $processos = Processo::where(function($query) {
                $query->where('estadoP', 'AUTORIZAÇÃO EMITIDA PELO TÉCNICO')
                      ->orWhere('estadoP', 'REGISTO EMITIDO PELO TÉCNICO');
            })
            ->where('responsavel_processo', Auth::user()->name)
            ->get();
        } 
        return view('processos.notificarSecPaprov', compact('processos')); 
    }

 




 
    public function create(Request $request)
    {
        $processo = new Processo();  
 
        if($request->tipo_processo=="Autorizacao"){
            $ultimoIDA=Processo::where(['tipo_processo'=>"Autorizacao"])->get()->last();
            if($ultimoIDA){
                $numDoc = $ultimoIDA['num_processo'];
                $newNumDoc=explode("_",$numDoc); //2_2023
    
                if($newNumDoc[1]==date('Y')){//ultimo num doc e de 2023
                    $newNum= $newNumDoc[0]+1;
                    $processo->num_processo =$newNum."_".date('Y')."_A";
                }else{                       //ultimo num doc e de ano anterior
                     $processo->num_processo ="1_".date('Y')."_A";
                }  
            }else{
                $processo->num_processo ="1_".date('Y')."_A";
            }
        }elseif($request->tipo_processo=="Registo"){
            $ultimoIDR=Processo::where(['tipo_processo'=>"Registo"])->get()->last();
            if($ultimoIDR){
                $numDoc = $ultimoIDR['num_processo'];
                $newNumDoc=explode("_",$numDoc); //2_2023
                
    
                if($newNumDoc[1]==date('Y')){//ultimo num doc e de 2023
                    $newNum= $newNumDoc[0]+1;
                    $processo->num_processo =$newNum."_".date('Y')."_R";
                }else{                       //ultimo num doc e de ano anterior
                     $processo->num_processo ="1_".date('Y')."_R";
                }  
            }else{
                $processo->num_processo ="1_".date('Y')."_R";
            }
        } 
        $processo->entidade=$request->entidade;
        $processo->preco_pago=$request->preco_pago;
        $processo->tipo_processo=$request->tipo_processo;
        $processo->descricao_processo=$request->descricao_processo;
        $processo->idForm=$request->idForm;
        $processo->tipo_entidade=$request->tipo_entidade; 
        $processo->estadoP="Novo";
        $processo->created_at=date('Y-m-d');
        $processo->save();

        if($processo->descricao_processo=="CCTV"){
            $cctv = Videovigilancia::find($processo->idForm); 
            $cctv->estado="Pendente";
            $cctv->save();
        }  

        if($processo->descricao_processo=="Interconexao"){
            $inter = Interconexao::find($processo->idForm); 
            $inter->estado="Pendente";
            $inter->save();
        }  
        if($request->descricao_processo=="Biometria"){
            $bio = Biometria::find($processo->idForm); 
            $bio->estado="Pendente";
            $bio->save();
        }  
        if($request->descricao_processo=="GPS"){
            $bio = Geolocalizacao::find($processo->idForm); 
            $bio->estado="Pendente";
            $bio->save();
        } 
        if($request->descricao_processo=="Geral"){
            $bio = Geral::find($processo->idForm); 
            $bio->estado="Pendente";
            $bio->save();
        } 
        if($request->descricao_processo=="TIC"){
            $bio = Tic::find($processo->idForm); 
            $bio->estado="Pendente";
            $bio->save();
        } 
        
        //logs
         //log do  criar processos

         $log = new Log;
         $log->user_id = auth()->user()->id;
         $log->user_name = auth()->user()->name;
         $log->id_evento = $processo->id;
         $log->nome_evento = $processo->tipo_processo;
         $log->action = 'Criar Processos';
         $log->tipo_evento = "Processos";
         $log->ip_address = $request->ip();
         $log->user_agent = $request->userAgent();
         $log->save();
 
        return redirect('/processos')->with('message','Processo gerado com sucesso!');
    }
 







    
    
    
    public function show($id)
    {
         
        $processo = Processo::find($id); 
         
        if($processo){ 
            $notaMultiplas = Processo::where('entidade', $processo->entidade)->get();   
            $getIdInspecao = Inspecao::where('id_processo', $processo->id)->count();

            if ($processo->responsavel_processo==Auth::user()->name || Gate::allows('fullMenu')) {  
            
                $docProcesso = DocProcesso::where('processo_id', $processo->id)->get();
                $autorizacao = AutorizacaoRegisto::where('idProcesso', $processo->id)->get();

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

                //logs desse processo
                $listarLogs = Log::where('tipo_evento', 'Processos')
                 ->where('id_evento', $processo->id)
                 //->orderBy('id', 'desc')
                 ->get();

                /****************PEGAR TODOS AS OBSERVACOES FEITAS NESSE PROCESSO ************************************************************************************************************************************************* */
                $listarComments = Comment::where('idp', $processo->id) 
                ->join('users', 'users.id', '=', 'comments.user_comment') 
                ->select('comments.*', 'users.name', 'users.typeUser')
                ->get();



                
                /****************CONSULTA PARA PEGAR TODOS OS PROCESSOS QUE NAO TEM NUMERO DE DUC E QUE PODEM SER MULTIPLOS************************************************************************************************************************************************* */
                $nome_denominacao = $processo->entidade; 
                $listaProcessosPendentes=Processo::whereNull('num_duc')
                ->where('entidade', $nome_denominacao)->get(); 
            
                /****************CONSULTA PARA PEGAR TODOS OS PROCESSOS QU PRECISAM DE ENVIAR DUC PARA NOTIFICANTE************************************************************************************************************************************************* */
                $listaProcessosParaenviarDuc=Processo::where('num_duc',$processo->num_duc)
                ->where('entidade', $nome_denominacao)->get();

                //LISTA DE TODOS OS PROCESSOS PRONTOS PARA ENVIO AO NOTIFICANTE
                $listaProcessosProntos=Processo::where('estadoP',"CONCLUIDO")
                     ->where('entidade', $nome_denominacao)->get(); 

                /****************SELECIONE OS TECNICOS ************************************************************************************************************************************************* */
                $getTecnicosInf=User::where('typeUser','Informatico')->get();
                $getTecnicosJur=User::where('typeUser','Jurista')->get(); 
                $getMembros = User::where('typeUser', 'Membro')
                   ->get();


                $getTecnicos=User::where('typeUser','Jurista')->where('typeUser','Informatico')->get();

                /****************VERIFICAR SE ESTE PROCESSO JA TEM INSPECAO FEITA ************************************************************************************************************************************************* */
                $inspecoes=Inspecao::where('id_processo', $processo->id)->get(); 
                /***********************PEGAR O ANEXO DO DUC E MOSTRAR NO SHOW************************************************************************************************** */
        
               // $caminho = "http://reportsta.gov.cv/reports/rwservlet?SIGOF_DUC&p_nu_duc=" . $processo->num_duc;
                $caminho = "http://reportsta.gov.cv/reports/rwservlet?SIGOF_DUC&p_nu_duc=923003286213";

                //CONSULTAR O ESTADO DO DUC E IMPRIMIR O ESTADO NO SHOW
                if($processo->estadoD!="PAGO"){
                    if($processo->num_duc!=""){
                        $email="celina.cruz@mf.gov.cv"; 
                        $url = 'https://api-pdex.gov.cv:8242/t/financas.gov/mfservicesduccreatev3/1.0.3/postProcessBancaEstadoDUC?p_duc=' . urlencode($processo->num_duc) . '&p_email=' . urlencode($email) . '';
                        $response = Http::withToken('160891a0-c761-377a-b922-a39a420929b4')
                        ->withHeaders([
                            'Content-Type' => 'application/json', 
                        ])
                        ->post($url); 
                        // Verifique se a solicitação foi bem-sucedida (código de status 2xx)
                        if ($response->getStatusCode() == 200) {
                            //Mensagem de sucesso se o duc foi gerado com sucesso
                
                            preg_match('/<DESCRICAO>(.*?)<\/DESCRICAO>/', $response, $matches);
                            $estado = $matches[1]; 
                            //  $estado; // Imprime "LIQUIDADO ou PAGO"   
                            if($estado=="LIQUIDADO") {
                                //$processo->estado="PENDENTE PAGAMENTO"; 
                            }elseif($estado=="PAGO") {
                                if ($processo->data_Pagaduc == "") {
                                    $processo->data_Pagaduc=date('Y-m-d H:i:s');
                                    $processo->estadoD="PAGO";
                                // $processo->estadoP="PAGO";
                                }    
                            } 
                            $processo->save(); 
                            //return back()->with('message', 'O estado desse DUC é: '.$duc.''); 
                        } else {
                        // return $responseData = json_decode($response->getBody()->getContents(), true); 
                            // A solicitação não foi bem-sucedida (código de status 4xx ou 5xx)
                            return back()->with('error', 'Ocorreu um erro ao enviar os dados. Tente novamente mais tarde.');
                        } 
                    }
                } 
                return view('processos.show')
                ->with('getTecnicosInf',$getTecnicosInf)
                ->with('getTecnicosJur',$getTecnicosJur)
                ->with('getMembros',$getMembros)
                ->with('processo',$processo) 
                ->with('notificacao',$notificacao)
                ->with('caminho',$caminho)
                ->with('getIdInspecao',$getIdInspecao) 
                ->with('listaProcessosPendentes',$listaProcessosPendentes) 
                ->with('listaProcessosParaenviarDuc',$listaProcessosParaenviarDuc)
                ->with('listaProcessosProntos',$listaProcessosProntos)   
                ->with('docProcesso',$docProcesso)
                ->with('autorizacao',$autorizacao)
                ->with('listarComments',$listarComments)
                ->with('listarLogs',$listarLogs) 
                ->with('inspecoes',$inspecoes)
                ->with('notaMultiplas',$notaMultiplas)
                ->with('listarLogs',$listarLogs);

            }else{
                return redirect()->back()->with('error', 'VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR ESSE PROCESSO!'); 
            }
        }else{
            return redirect()->back()->with('error', 'ESTE PROCESSO NÃO EXISTE!'); 
        }
        
    }












    public function gerarDuc(Request $request) {
        $processo = Processo::find($request->idp); 
        $p_valor=$processo->preco_pago;
        $p_email="celina.cruz@mf.gov.cv";
        $url = 'https://api-pdex.gov.cv:8242/t/financas.gov/mfservicesduccreatev3/1.0.3/postProcessBanca?p_valor=' . urlencode($p_valor) . '&p_moeda=' . urlencode($request->p_moeda) . '&p_recebedoria=' . urlencode($request->p_recebedoria) . '&p_email=' . urlencode($p_email) . '&p_nif=' . urlencode($request->p_nif) . '&p_obs=' . urlencode($request->p_obs) . '&p_codTransacao=' . urlencode($request->p_codTransacao) . '&p_valor1=' . urlencode($request->p_valor1) .'&p_codTransacao1=' . urlencode($request->p_codTransacao1) . '&p_valor2=' . urlencode($request->p_valor2) .'&p_codTransacao2=' . urlencode($request->p_codTransacao2) . '';
         
        $response = Http::withToken('160891a0-c761-377a-b922-a39a420929b4')
        ->withHeaders([
            'Content-Type' => 'application/json',
           
        ])
        ->post($url);
        
        // Verifique se a solicitação foi bem-sucedida (código de status 2xx)
        if ($response->getStatusCode() == 200) {
            //Mensagem de sucesso se o duc foi gerado com sucesso
              preg_match('/<DUC>(.*?)<\/DUC>/', $response, $matches);
              $duc = $matches[1];
              
             //  $duc; // Imprime "923003010830"   
            $processo->num_duc=$duc;
            $processo->estadoD="PENDENTE PAGAMENTO";
            $processo->estadoP="PENDENTE PAGAMENTO";
            $processo->save();

            //log do  gerar Duc

            $log = new Log;
            $log->user_id = auth()->user()->id;
            $log->user_name = auth()->user()->name;
            $log->id_evento = $processo->id;
            $log->nome_evento = $processo->tipo_processo;
            $log->action = 'Gerar Duc';
            $log->tipo_evento = "Processos";
            $log->ip_address = $request->ip();
            $log->user_agent = $request->userAgent();
            $log->save();

            //DEPOIS DE GERAR DUC VAMOS FAZER O DOWNLOAD DO DUC PDF E SALVAR NA PASTA PROCESSOS
            $processo = Processo::find($request->idp);  
            // Define o URL do endpoint
            $url = 'http://reportsta.gov.cv/reports/rwservlet?SIGOF_DUC&p_nu_duc=' . $processo->num_duc;
            // Define o nome do arquivo que será salvo
            $filename = "DUC ".date('Y-m-d H-i-s').".pdf"; 
            
            // Define o caminho completo para a pasta storage/processos onde o arquivo será salvo
            //$path = 'processos/' . $filename;
            
            
            // Define o caminho completo para a pasta public/processos onde o arquivo será salvo
            $path = public_path('ducs/' . $filename);

            // Cria um objeto cliente GuzzleHttp
            $client = new Client();
            // Faz o download do arquivo usando o cliente GuzzleHttp
            $response = $client->request('GET', $url);

            // Grava o conteúdo do arquivo na pasta public/processos
            file_put_contents($path, (string) $response->getBody());  
            // Grava o conteúdo do arquivo na pasta storage/processos
            //  Storage::put($path, (string) $response->getBody());


            $processo->anexo_duc=$filename;
            $processo->save(); 

            return back()->with('message', 'DUC gerado com sucesso! O número do DUC é: '.$duc.''); 
        } else {
            return $responseData = json_decode($response->getBody()->getContents(), true); 
            // A solicitação não foi bem-sucedida (código de status 4xx ou 5xx)
            return redirect()->back()->with('error', 'Ocorreu um erro ao enviar os dados. Tente novamente mais tarde.');
        } 
    }














    public function gerarDucM(Request $request) {   
        $p_email="celina.cruz@mf.gov.cv";
        $url = 'https://api-pdex.gov.cv:8242/t/financas.gov/mfservicesduccreatev3/1.0.3/postProcessBanca?p_valor=' . urlencode($request->p_valor) . '&p_moeda=' . urlencode($request->p_moeda) . '&p_recebedoria=' . urlencode($request->p_recebedoria) . '&p_email=' . urlencode($p_email) . '&p_nif=' . urlencode($request->p_nif) . '&p_obs=' . urlencode($request->p_obs) . '&p_codTransacao=' . urlencode($request->p_codTransacao) . '&p_valor1=' . urlencode($request->p_valor1) .'&p_codTransacao1=' . urlencode($request->p_codTransacao1) . '&p_valor2=' . urlencode($request->p_valor2) .'&p_codTransacao2=' . urlencode($request->p_codTransacao2) . '';
         
        $response = Http::withToken('160891a0-c761-377a-b922-a39a420929b4')
        ->withHeaders([
            'Content-Type' => 'application/json',
           
        ])
        ->post($url);
        
        // Verifique se a solicitação foi bem-sucedida (código de status 2xx)
        if ($response->getStatusCode() == 200) {
            //Mensagem de sucesso se o duc foi gerado com sucesso
 
              preg_match('/<DUC>(.*?)<\/DUC>/', $response, $matches);
              $duc = $matches[1];
              
             //  $duc; // Imprime "923003010830"   

/****************CONSULTA PARA PEGAR TODOS OS PROCESSOS QUE NAO TEM NUMERO DE DUC E QUE PODEM SER MULTIPLOS************************************************************************************************************************************************* */
        $processo = Processo::find($request->id);

        $nome_denominacao = $processo->entidade; 
        $listaProcessosPendentes=Processo::whereNull('num_duc')->get(); 

        foreach($listaProcessosPendentes as $processoPendente) {
            if($processoPendente->entidade==$nome_denominacao) {
                $processoPendente->num_duc=$duc;
                $processoPendente->estadoD="PENDENTE PAGAMENTO";
                $processoPendente->estadoP="PENDENTE PAGAMENTO";
                $processoPendente->save();

                // log gerar duc multiplo
                $log = new Log;
                $log->user_id = auth()->user()->id;
                $log->user_name = auth()->user()->name;
                $log->id_evento = $processoPendente->id;
                $log->nome_evento = $processo->tipo_processo;
                $log->action = 'Gerar Duc Multiplo';
                $log->tipo_evento = "Processos";
                $log->ip_address = $request->ip();
                $log->user_agent = $request->userAgent();
                $log->save();
            }
        }  
        

        //DEPOIS DE GERAR DUC VAMOS FAZER O DOWNLOAD DO DUC PDF E SALVAR NA PASTA PROCESSOS
        $GerarPdfDucs=Processo::where('num_duc',$duc)->get();  
        // Define o URL do endpoint
        $url = 'http://reportsta.gov.cv/reports/rwservlet?SIGOF_DUC&p_nu_duc=' . $duc;
        // Define o nome do arquivo que será salvo
        $filename = "DUC ".date('Y-m-d H-i-s').".pdf";

        
        // Define o caminho completo para a pasta public/processos onde o arquivo será salvo
        $path = public_path('ducs/' . $filename); 
        // Define o caminho completo para a pasta storage/processos onde o arquivo será salvo
       //  $path = 'processos/' . $filename;
        // Cria um objeto cliente GuzzleHttp
        $client = new Client();
        // Faz o download do arquivo usando o cliente GuzzleHttp
        $response = $client->request('GET', $url);
 
        // Grava o conteúdo do arquivo na pasta public/ducs
        file_put_contents($path, (string) $response->getBody());

        // Grava o conteúdo do arquivo na pasta storage/processos
      //  Storage::put($path, (string) $response->getBody());

        foreach($GerarPdfDucs as $GerarPdfDuc) {
            if($GerarPdfDuc->entidade==$nome_denominacao) {
                $GerarPdfDuc->anexo_duc=$filename;
                $GerarPdfDuc->save();
            }
        }  

        return back()->with('message', 'DUC Múltiplo gerado com sucesso! O número do DUC é: '.$duc.''); 
        } else {
            return $responseData = json_decode($response->getBody()->getContents(), true); 
            // A solicitação não foi bem-sucedida (código de status 4xx ou 5xx)
            return redirect()->back()->with('error', 'Ocorreu um erro ao enviar os dados. Tente novamente mais tarde.');
        } 
    }











    
    public function enviarDucEmail(Request $request){ 
        
        $processo = Processo::find($request->id); 

        $nome_denominacao = $processo->entidade;

        $listaProcessosParaenviarDuc=Processo::where('num_duc',$processo->num_duc)
        ->where('entidade', $nome_denominacao)->get(); 

        $data["email"] = $request->email;
        $data["title"] = "Envio de DUC - CNPD";
        $data["cc"] = $request->emailCC;
        $data["body"] = "
        Bom dia,
        <br>
        Em anexo enviamos o DUC referente ao(s) processo(s) de Tratamento de Dados Pessoais, conforme solicitado.
        <br>   
         <b>$request->conteudo</b>
         <br><br>
        Para os devidos efeitos.<br>
        <br>  <br>   
        Cmprts<br>  
        Comissão Nacional de Protecção de Dados - CNPD<br> 
        Av. da China, Rampa Terra Branca, Apartado 1002 - C.P. 7600<br> 
        Tel: 5340390   https://www.cnpd.cv  cnpd@cnpd.cv";
    
        $pdf = [base_path('public/ducs/'.$processo->anexo_duc.'')];

       Mail::send('mail.Test_mail', $data, function($message)use($data,$pdf) {
             if($data["cc"] != null){
                $message->to($data["email"])
                ->subject($data["title"])
                ->cc($data["cc"]);
            }else{
                $message->to($data["email"])
                ->subject($data["title"]);
            }
            
 
            foreach ($pdf as $file){
                $message->attach($file); 
            }            
        });  
         
        //dd(count($listaProcessosParaenviarDuc));
            if(count($listaProcessosParaenviarDuc) > 1){
                foreach ($listaProcessosParaenviarDuc as $envioduc) { 
                    if($envioduc->entidade==$nome_denominacao) {
                        $envioduc->estadoP="DUC ENVIADO";
                        $envioduc->save();
                    }
                    //Log envio de DUC por email
                    $log = new Log;
                    $log->user_id = auth()->user()->id;
                    $log->user_name = auth()->user()->name;
                    $log->id_evento = $envioduc->id;
                    $log->nome_evento = $processo->tipo_processo;
                    $log->action = 'Enviar Duc por email';
                    $log->tipo_evento = "Processos";
                    $log->ip_address = $request->ip();
                    $log->user_agent = $request->userAgent();
                    $log->save();
                }
            }else{
                if($processo->entidade==$nome_denominacao) {
                    $processo->estadoP="DUC ENVIADO";
                    $processo->save();
                } 
                //Log envio de DUC por email
                $log = new Log;
                $log->user_id = auth()->user()->id;
                $log->user_name = auth()->user()->name;
                $log->id_evento = $processo->id;
                $log->nome_evento = $processo->tipo_processo;
                $log->action = 'Enviar Duc por email';
                $log->tipo_evento = "Processos";
                $log->ip_address = $request->ip();
                $log->user_agent = $request->userAgent();
                $log->save();
            } 
            
            return back()->with('message','DUC enviado com sucesso á entidade '.$processo->entidade.'!');
    }

 






    

    public function processoUrg(Request $request) {
        $processo = Processo::find($request->id);
        $processo->p_urgente=1; 
        $processo->save();

         //Log gerar processo urgente
         $log = new Log;
         $log->user_id = auth()->user()->id;
         $log->user_name = auth()->user()->name;
         $log->id_evento = $processo->id;
         $log->nome_evento = $processo->tipo_processo;
         $log->action = 'Gerar Processo Urgente';
         $log->tipo_evento = "Processos";
         $log->ip_address = $request->ip();
         $log->user_agent = $request->userAgent();
         $log->save();
        return back()->with('message', 'Processo marcado como urgente com sucesso!'); 
    }
   







    

    public function submeterNovoDoc(Request $request)
    { 
        $doc = new DocProcesso();
        $doc->processo_id=$request->idProcesso;
        $doc->name=$request->name;

        if($request->fileDoc) { 
            $nameBd= date('Y-m-d H-i-s').'.'.$request->fileDoc->extension(); 
          $fileSave = $request->fileDoc->storeAs('processos',$nameBd); 
          $doc->file=$nameBd;
        }     
        $doc->created_at=date('Y-m-d H:i:s');
        $doc->estado="Novo";
        $doc->save();
  
     

       //log do  submeter novo documento

       $log = new Log;
       $log->user_id = auth()->user()->id;
       $log->user_name = auth()->user()->name;
       $log->id_evento = $doc->processo_id;
       $log->nome_evento = $doc->name;
       $log->action = 'Submeter Novo Documento';
       $log->tipo_evento = "Processos";
       $log->ip_address = $request->ip();
       $log->user_agent = $request->userAgent();
       $log->save();

        


       

        return back()->with('message','Documento submetido com sucesso!');
    }
  








    public function atribuirProcessoT(Request $request) {
        $processo = Processo::find($request->id);
        $processo->responsavel_processo=$request->relator;
        $processo->estadoP="EM ANÁLISE PELO TÉCNICO";
        $processo->data_receber_processo=date('Y-m-d H:i:s'); 
        
        $processo->save();
        

         //log do  submeter novo documento

       $log = new Log;
       $log->user_id = auth()->user()->id;
       $log->user_name = auth()->user()->name;
       $log->id_evento = $processo->id;
       $log->nome_evento = $processo->entidade;
       $log->action = 'Atribuir processo ao técnico - '.$request->relator;
       $log->tipo_evento = "Processos";
       $log->ip_address = $request->ip();
       $log->user_agent = $request->userAgent();
       $log->save();
        return back()->with('message', 'Processo atribuido ao técnico '.$request->relator.' com sucesso!'); 

    }








    public function atribuirProcessoM(Request $request) {
        $processo = Processo::find($request->id);
        $processo->responsavel_processo=$request->relator;
        $processo->estadoP="EM ANÁLISE PELO MEMBRO";
        $processo->data_receber_processo=date('Y-m-d H:i:s'); 
        $processo->save();

        //log do  submeter novo documento

       $log = new Log;
       $log->user_id = auth()->user()->id;
       $log->user_name = auth()->user()->name;
       $log->id_evento = $processo->id;
       $log->nome_evento = $processo->entidade;
       $log->action = 'Atribuir processo ao Membro - '.$request->relator;
       $log->tipo_evento = "Processos";
       $log->ip_address = $request->ip();
       $log->user_agent = $request->userAgent();
       $log->save();

        return back()->with('message', 'Processo atribuido ao Membro '.$request->relator.' com sucesso!'); 
    }








    public function gerarAuto(Request $request) {
        $processo = Processo::find($request->id); 
        $auto = new AutorizacaoRegisto(); 
        $auto->tipo_entidade=$processo->descricao_processo;
        $auto->tipo_processo=$processo->tipo_processo;
         
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
         

        if($processo->tipo_processo=="Autorizacao"){   
            $ultimoAuto = AutorizacaoRegisto::where('num_decisao', 'LIKE', '%/A%')
            ->orderBy('id', 'desc')
            ->first();

            if($ultimoAuto){
                $numDoc = $ultimoAuto['num_decisao'];
                $newNumAut=explode("/",$numDoc); //1/2023_A
    
                if($newNumAut[1]==date('Y')){//ultimo num doc e de 2023
                    $newNum= $newNumAut[0]+1;
                    $auto->num_decisao =$newNum."/".date('Y')."/A";
                }else{ //ultimo num doc e de ano anterior
                     $auto->num_decisao ="1/".date('Y')."/A";
                }  
            }else{
                $auto->num_decisao ="1/".date('Y')."/A";
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
                    $auto->num_decisao =$newNum."/".date('Y')."/R";
                }else{//ultimo num doc e de ano anterior
                     $auto->num_decisao ="1/".date('Y')."/R";
                }  
            }else{
                $auto->num_decisao ="1/".date('Y')."/R";
            }
        }  
        $auto->idProcesso=$processo->id; 
        $auto->entidade=$processo->entidade;
        $auto->data_decisao="";   
        $auto->estado="AGUARDANDO APROVAÇÃO"; 
        $auto->save();
        $processo->responsavel_processo="Decisão Automática";
        $processo->estadoP="AGUARDANDO APROVAÇÃO";
        $processo->save(); 
        $namePdf=$processo->entidade."_".$processo->descricao_processo.".pdf"; 
        $lastAutoSave = AutorizacaoRegisto::latest()->first();
        $pdf = PDF::loadView('processos.autoPdf', compact('processo','notificacao','lastAutoSave'));  
        $pdf_content = $pdf->output(); 
        file_put_contents(public_path("autos/$namePdf"), $pdf_content);
        $lastAutoSave->anexo=$namePdf;
        $lastAutoSave->save(); 

        //log do  gerar autorização

       $log = new Log;
       $log->user_id = auth()->user()->id;
       $log->user_name = auth()->user()->name;
       $log->id_evento = $processo->id;
       $log->nome_evento = $processo->entidade;
       $log->action = 'Gerar decisão automático';
       $log->tipo_evento = "Processos";
       $log->ip_address = $request->ip();
       $log->user_agent = $request->userAgent();
       $log->save();
                    
        return back()->with('message','Autorização gerado com sucesso!');

    }








    public function notificarSec(Request $request) {
        $processo = Processo::find($request->id);
        $processo->estadoP="AGUARDANDO APROVAÇÃO";
        $processo->save();

        //log da notificar secretaria

        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $processo->id;
        $log->nome_evento = $processo->tipo_processo;
        $log->action = 'Notificar Secretário da conclusão do processo';
        $log->tipo_evento = "Processos";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();
        return back()->with('message', 'Notificação enviado com sucesso!'); 
    }








   

    public function gerarNota(Request $request,$idp) {
        $processo = Processo::find($idp);  


       if($processo->descricao_processo=="CCTV"){
             //SALVAR QR CODE DA AUTORIZACAO
            $getAuto = DB::table('autorizacao_registos')
            ->join('processos', 'autorizacao_registos.idProcesso', '=', 'processos.id')
            ->where('processos.id', $idp)
            ->get();

            if ($getAuto) {
                foreach ($getAuto as $auto) {
                    $pdfLink = 'http://localhost:8000/autos/' . $auto->anexo; // Substitua pelo caminho correto para o seu arquivo PDF
                // Gera o QR code com o link do PDF
                    $qrCode = QrCode::generate($pdfLink);

                    // Define o caminho para salvar o QR code
                    $qrCodePath = 'qrcodes/'.$auto->entidade."_".$processo->id.'.svg'; // Caminho e nome do arquivo para salvar o QR code
                    $processo->qrcode=$auto->entidade."_".$processo->id.'.svg';
                    $processo->save();
                    // Verifica se o diretório de destino existe, caso contrário, cria-o
                    $directory = public_path(dirname($qrCodePath)); 
                    // Salva o QR code na pasta pública
                    file_put_contents(public_path($qrCodePath), $qrCode);

                    $response = response()->file(public_path($qrCodePath));
                }
            }

            //GERAR IMAGEM DE AVISO CCTV COM QR CODE INCLUSO
            $pdf = PDF::loadView('processos.avisoCCTV', compact('processo','getAuto'));  
            $pdf_content = $pdf->output();  
            $nameAviso="Aviso CCTV ".$processo->entidade.".pdf";  
            $processo->aviso=$nameAviso;
            $processo->save();
            file_put_contents(public_path("qrcodes/$nameAviso"), $pdf_content);
             
       }


        $autos = DB::table('processos')
        ->join('autorizacao_registos', 'processos.id', '=', 'autorizacao_registos.idProcesso')
        ->where('processos.entidade', $processo->entidade)
        ->select('processos.*', 'autorizacao_registos.*')
        ->get();


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

        $notaMultiplas = Processo::where('entidade', $processo->entidade)->get();   
        
        
        //NOTAS MULTIPLAS ENTIDADE COM VARIOS PROCESSOS PARA EMITIR NOTA DESPACHO
        if(count($notaMultiplas) > 1){ 

            /*$ultimoNota = Processo::whereNotNull('num_notadesp')
            ->latest('num_notadesp')
            ->first();*/ 
            $ultimoNota = Processo::whereNotNull('num_notadesp')
            ->orderByRaw('CAST(num_notadesp AS UNSIGNED) DESC')
            ->first();

            if ($ultimoNota) {
                $numDoc = $ultimoNota->num_notadesp;
                $newNumNot = explode("_", $numDoc);

                if (isset($newNumNot[1]) && $newNumNot[1] == date('Y')) {
                    $newNum = $newNumNot[0] + 1;
                    $notaM = $newNum . "_" . date('Y');
                } else {
                    $notaM = "1_" . date('Y');
                }
            } else {
                $notaM = "1_" . date('Y');
            }
  
            foreach($notaMultiplas as $notaMultipla) { 
                $notaMultipla->num_notadesp = $notaM;
                $notaMultipla->save(); 
            }
 
            $results = DB::table('processos')
            ->join('autorizacao_registos', 'processos.id', '=', 'autorizacao_registos.idProcesso')
            ->where('processos.id', $idp)
            ->select('processos.*', 'autorizacao_registos.*')
            ->get();
    
            
            $pdf = PDF::loadView('processos.notaDespacho', compact('results','autos','notaMultiplas','notificacao'));  
            $pdf_content = $pdf->output();  
            $namePdf="Nota Despacho ".$notaMultipla->num_notadesp.".pdf";  
            file_put_contents(public_path("notas/$namePdf"), $pdf_content); 

            foreach($notaMultiplas as $notaMultipla) { 
                $notaMultipla->anexo_notadesp=$namePdf;
                $notaMultipla->estadoP="CONCLUIDO";
                $notaMultipla->save(); 

                //LOGS DE GERAR  NOTA DESPACHO
                $log = new Log;
                $log->user_id = auth()->user()->id;
                $log->user_name = auth()->user()->name;
                $log->id_evento = $notaMultipla->id;
                $log->nome_evento = $notaMultipla->tipo_processo;
                $log->action = 'Gerar Nota Despacho';
                $log->tipo_evento = "Processos";
                $log->ip_address = $request->ip();
                $log->user_agent = $request->userAgent();
                $log->save();


            }
        //NOTAS SIMPLES UNICO PROCESSO DESSA ENTIDADE
        }else{ 
            /*$ultimoNota = Processo::whereNotNull('num_notadesp')
                ->latest('num_notadesp')
                ->first();*/ 
            $ultimoNota = Processo::whereNotNull('num_notadesp')
                ->orderByRaw('CAST(num_notadesp AS UNSIGNED) DESC')
                ->first();
 
            if ($ultimoNota) {
                $numDoc = $ultimoNota->num_notadesp;
                $newNumNot = explode("_", $numDoc);

                if (isset($newNumNot[1]) && $newNumNot[1] == date('Y')) {
                    $newNum = $newNumNot[0] + 1;
                    $processo->num_notadesp = $newNum . "_" . date('Y');
                } else {
                    $processo->num_notadesp = "1_" . date('Y');
                }
            } else {
                $processo->num_notadesp = "1_" . date('Y');
            }
 
            $processo->save();
 
            $results = DB::table('processos')
            ->join('autorizacao_registos', 'processos.id', '=', 'autorizacao_registos.idProcesso')
            ->where('processos.id', $idp)
            ->select('processos.*', 'autorizacao_registos.*')
            ->get();
    
            
            $pdf = PDF::loadView('processos.notaDespacho', compact('results','autos','notaMultiplas','notificacao'));  
            $pdf_content = $pdf->output();  
            $namePdf="Nota Despacho ".$processo->num_notadesp.".pdf";  
            file_put_contents(public_path("notas/$namePdf"), $pdf_content);
            $processo->estadoP="CONCLUIDO";
            $processo->anexo_notadesp=$namePdf;
            $processo->save(); 

            //LOGS DE GERAR  NOTA DESPACHO
            $log = new Log;
            $log->user_id = auth()->user()->id;
            $log->user_name = auth()->user()->name;
            $log->id_evento = $idp;
            $log->nome_evento = $processo->tipo_processo;
            $log->action = 'Gerar Nota Despacho';
            $log->tipo_evento = "Processos";
            $log->ip_address = $request->ip();
            $log->user_agent = $request->userAgent();
            $log->save();

        }
 


                
        return back()->with('message','Nota Despacho gerado com sucesso!');

}








public function enviarNotaAutoEmail(Request $request,$idp){ 
        
    $processo = Processo::find($idp);  

    if($processo->descricao_processo=="CCTV"){ 
        $notificacao = "Videovigilância";
        $dadosNotif = Videovigilancia::where('id', $processo->idForm)->get();
    } elseif($processo->descricao_processo=="Interconexao"){
        $notificacao = "Interconexão";
        $dadosNotif = Interconexao::where('id', $processo->idForm)->get();
    }elseif($processo->descricao_processo=="Biometria"){
        $notificacao = "Biometria";
        $dadosNotif = Biometria::where('id', $processo->idForm)->get();
    }elseif($processo->descricao_processo=="Geral"){
        $notificacao = "Tratamento de Dados Geral";
        $dadosNotif = Geral::where('id', $processo->idForm)->get();
    }elseif($processo->descricao_processo=="GPS"){
        $notificacao = "Geolocalização";
        $dadosNotif = Geolocalizacao::where('id', $processo->idForm)->get();
    }elseif($processo->descricao_processo=="TIC"){
        $notificacao = "TIC";
        $dadosNotif = Tic::where('id', $processo->idForm)->get();
    }

    $nome_denominacao = $processo->entidade;

    $listaProcessosProntos=Processo::where('estadoP',"CONCLUIDO")
    ->where('entidade', $nome_denominacao)->get(); 


    $auto = AutorizacaoRegisto::where('idProcesso', $processo->id)->get();

    if($dadosNotif){
        $data["email"] = $dadosNotif[0]->email_responsavel_tratamento;
    } 
    $data["title"] = "Autorização - ".$nome_denominacao; 
    $data["body"] = "
    Bom dia,
    <br>
    Segue anexo a Nota de Despacho e a Autorização do Processo de $notificacao.  
    <br><br>
    Para os devidos efeitos.<br>
    <br>  <br>   
    Cmprts<br>  
    Comissão Nacional de Protecção de Dados - CNPD<br> 
    Av. da China, Rampa Terra Branca, Apartado 1002 - C.P. 7600<br> 
    Tel: 5340390   https://www.cnpd.cv  cnpd@cnpd.cv";
 
    if ($auto) {
        $autoPDF = base_path('public/autos/' . $auto[0]->anexo);
    }
    $notaPDF = base_path('public/notas/' . $processo->anexo_notadesp);

    //SE FOR CCTV ENVIA TAMBEM O MODELO DE AVISO
    if($processo->descricao_processo=="CCTV"){ 
        $aviso = base_path('public/qrcodes/' . $processo->aviso);
        Mail::send('mail.Test_mail', $data, function ($message) use ($data, $autoPDF, $notaPDF, $aviso) {
            $message->to($data["email"])
                ->subject($data["title"]);
        
            $message->attachFromPath($autoPDF);
            $message->attachFromPath($notaPDF);
            $message->attachFromPath($aviso);
        }); 
    }else{  
        Mail::send('mail.Test_mail', $data, function ($message) use ($data, $autoPDF, $notaPDF) {
            $message->to($data["email"])
                ->subject($data["title"]);
        
            $message->attachFromPath($autoPDF);
            $message->attachFromPath($notaPDF);
        });
        
    } 
     
    if($processo->entidade==$nome_denominacao) {
        $processo->estadoP="ARQUIVADO";
        $processo->save();
    } 

    //Log envio de nota e auto por email
    $log = new Log;
    $log->user_id = auth()->user()->id;
    $log->user_name = auth()->user()->name;
    $log->id_evento = $processo->id;
    $log->nome_evento = $processo->tipo_processo;
    $log->action = 'Enviar Auto e Nota despacho ao Notificante';
    $log->tipo_evento = "Processos";
    $log->ip_address = $request->ip();
    $log->user_agent = $request->userAgent();
    $log->save();
    
    return back()->with('message','Autorização e Nota Despacho enviado com sucesso á entidade '.$processo->entidade.'!');
}




//CONSULTAR O ESTADO DO PROCESSO NO SITE 
    public function ConsultarProcesso()
    {  
         $results = DB::table('processos')   
         ->select('processos.*')  
            ->get(); 
        if ($results) {
            return response()->json(['success' => true, 'data' => $results]);
        } else {
            return response()->json(['success' => false, 'message' => 'Número DUC não encontrado.']);
        }
          
    } 

    

  
}