<?php 


namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Processo; 
use App\Models\Videovigilancia; 
use App\Models\Interconexao;
use App\Models\Biometria;
use App\Models\Geral;
use App\Models\Geolocalizacao;
use App\Models\Tic;
use App\Models\Reuniao;
use App\Models\PedidoInformacao;

class HeaderComposer
{
    public function compose(View $view)
    {
       
        if (Auth::check()) {
 
        /********************** ************************ SECRETARIO ************************************************ */
                //TOTAL DE NOVOS PROCESSOS QUE DERAM ENTRADA NO SISTEMA
                $novoCCTV = Videovigilancia::where('estado', 'Novo')->count();
                $novoInter = Interconexao::where('estado', 'Novo')->count();
                $novoBio = Biometria::where('estado', 'Novo')->count();
                $novoGeral = Geral::where('estado', 'Novo')->count();
                $novoGeo = Geolocalizacao::where('estado', 'Novo')->count();
                $novoTic = Tic::where('estado', 'Novo')->count();
               

                //TOTAL DE PROCESSOS PRONTOS PARA SEREM APROVADOS PELOS MEMBROS
                $processosParaAprovacao = Processo::where('estadoP', 'AGUARDANDO APROVAÇÃO')->get(); 
                $countParaAprovacao=count($processosParaAprovacao); 
        
                //PROCESSOS AGUARDANDO NOTA DESPACHO DO SECRETARIO 
                $aguardandoNotas = Processo::where('estadoP', "PROCESSO APROVADO")->get();  
                $countAguardarNotas=count($aguardandoNotas);

                //PROCESSOS CONCLUIDOS AGUAARDANDO ENVIO DE AUTORIZACAO PARA O REQUERENTE
                $prontoEnvio = Processo::where('estadoP', "CONCLUIDO")->get();  
                $countProntosEnvio=count($prontoEnvio);

                //TOTAL DE PEDIDOS DE ESCLARECIMENTOS NO SITE  
                $novoPedidosInformacao = PedidoInformacao::where('estado', "Novo")->get();  
                $countPedidos=count($novoPedidosInformacao);
                //SOMA DE TODOS OS COUNTS PARA SEREM EXIBIDOS NA HEADER DO SECRETARIO
                $countTotalSec=$novoCCTV+$novoInter+$novoBio+$novoGeral+$novoGeo+$novoTic+$countParaAprovacao+$countAguardarNotas+$countProntosEnvio+$countPedidos;

        /******************************************** ASSISTENTE *************** ************************************* */

                $countTotalAssist=$novoCCTV+$novoInter+$novoBio+$novoGeral+$novoGeo+$novoTic;

        /******************************************** TECNICO *************** ************************************* */
                //TOTAL DE PROCESSOS ATRIBUIDOS AO TECNICO PARA SER ANALISADO
                $countProcessAtribuidosTec = Processo::where('responsavel_processo', '=', Auth::user()->name)
                ->where('estadoP', '=', 'EM ANÁLISE PELO TÉCNICO')
                ->count(); 
                
                //TOTAL DE PROCESSOS AGUARDANDO PARA NOTIFICAR O SECRETARIO 
                $NotificarSecretario = Processo::where(function($query) {
                $query->where('estadoP', 'AUTORIZAÇÃO EMITIDA PELO TÉCNICO')
                        ->orWhere('estadoP', 'REGISTO EMITIDO PELO TÉCNICO');
                })
                ->where('responsavel_processo', Auth::user()->name)
                ->get(); 
                $countNotificarSec=count($NotificarSecretario); 


                //SOMA DE TODOS OS COUNTS PARA SEREM EXIBIDOS NA HEADER DO TECNICO
                $countTotalTecnico=$countProcessAtribuidosTec+$countNotificarSec;


        /************************************** ***** MEMBRO *************** ************************************* */

                //TOTAL DE PROCESSOS ATRIBUIDOS AO MEMBRO PARA SER ANALISADO
                $countProcessAtribuidosMembro = Processo::where('responsavel_processo', '=', Auth::user()->name)
                ->where('estadoP', '=', 'EM ANÁLISE PELO MEMBRO')
                ->count();  

                //TOTAL DE PROCESSOS AGUARDANDO PARA NOTIFICAR O SECRETARIO  
                $NotificarSecretarioM = Processo::where(function($query) {
                $query->where('estadoP', 'AUTORIZAÇÃO EMITIDA PELO MEMBRO')
                        ->orWhere('estadoP', 'REGISTO EMITIDO PELO MEMBRO');
                })
                ->where('responsavel_processo', Auth::user()->name)
                ->get();  
                $countNotificarSecM=count($NotificarSecretarioM); 


                //TOTAL DE PROCESSOS PRONTOS PARA REUNIAO
                $processosReuniao = Reuniao::where('estadoR', 'Agendada')->get(); 
                $ProcessosReuniaoCount=count($processosReuniao); 


                //SOMA DE TODOS OS COUNTS PARA SEREM EXIBIDOS NA HEADER DO MEMBRO
                $countTotalMembro=$countProcessAtribuidosMembro+$countNotificarSecM+$ProcessosReuniaoCount;



                
        /********************** ******************** ***** MEMBRO *************** ******************** ******************** */
                $view->with('countTotalAssist', $countTotalAssist)  
                ->with('processosReuniao', $processosReuniao)
                ->with('ProcessosReuniaoCount', $ProcessosReuniaoCount)
                ->with('countTotalMembro', $countTotalMembro)
                ->with('countTotalSec', $countTotalSec)
                ->with('countTotalTecnico', $countTotalTecnico) 
                ->with('countParaAprovacao', $countParaAprovacao)
                ->with('countNotificarSec', $countNotificarSec)
                ->with('countNotificarSecM', $countNotificarSecM)
                ->with('processosParaAprovacao', $processosParaAprovacao)
                ->with('countProcessAtribuidosTec', $countProcessAtribuidosTec)
                ->with('countProcessAtribuidosMembro', $countProcessAtribuidosMembro) 
                ->with('countAguardarNotas', $countAguardarNotas)
                ->with('countProntosEnvio', $countProntosEnvio) 
                ->with('countPedidos', $countPedidos)   
                ->with('countNovosPedidos')
                ->with('novoCCTV', $novoCCTV)
                ->with('novoInter', $novoInter)
                ->with('novoBio', $novoBio)
                ->with('novoGeral', $novoGeral)
                ->with('novoGeo', $novoGeo)
                ->with('novoTic', $novoTic);
        }
    }
}