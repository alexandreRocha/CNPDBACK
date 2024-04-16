@extends('layouts.master')
@section('title', 'Ver Processo')
@section('content')

@if($processo)
<!-- Breadcrumbs -->
{{ Breadcrumbs::render('Ver Processo', $processo) }}

<link href="{{ asset('admin/css/styleDatatable.css') }}" rel="stylesheet" type="text/css">
    
<!-- ALERT-->
@if(session('message'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Success!</h4>
    <p id="alerta">{{ session('message')}}</p>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger" role="alert"> 
    <h4 class="alert-heading">Upss!</h4>
    <p id="alerta">{{ session('error')}}</p>
</div>
@endif


<link href="{{ asset('admin/css/styleDatatable.css') }}" rel="stylesheet" type="text/css">
    <div class="col-md-12">
    @if($processo->estadoP=="ARQUIVADO") 
        <div style="text-align:center" class="alert alert-success alert-fixed">
            <h4 class="alert-heading"><b>PROCESSO FINALIZADO</b> </h4> 
        </div>
    @endif
    </div>
    <div class="nova">
    
        <!-- BOTOES COM OS EVENTOS PARA OS SERVICOS ADMINISTRATIVO, GERAR DUC, ENVIAR DUC, ETC -->
        @can('gerar-processo-gerar-duc')
            @if($processo->anexo_forms=="")
                @if($processo->descricao_processo=="CCTV")
                <a class="btn btn-danger" href="{{ route('gerarPdfcctv', ['id' => $processo->idForm,'idp' => $processo->id]) }}">
                    <i class="fas fa-fw fa-print"></i>
                    Gerar PDF Formulário
                </a>
                @endif
                @if($processo->descricao_processo=="Interconexao")
                <a class="btn btn-danger" href="{{ route('gerarPdfinter', ['id' => $processo->idForm,'idp' => $processo->id]) }}">
                    <i class="fas fa-fw fa-print"></i>
                    Gerar PDF Formulário
                </a>
                @endif
                @if($processo->descricao_processo=="Biometria") 
                <a class="btn btn-danger" href="{{ route('gerarPdfbio', ['id' => $processo->idForm,'idp' => $processo->id]) }}">
                    <i class="fas fa-fw fa-print"></i>
                    Gerar PDF Formulário
                </a>
                @endif 
                @if($processo->descricao_processo=="Geral")
                <a class="btn btn-danger" href="{{ route('gerarPdfgeral', ['id' => $processo->idForm,'idp' => $processo->id]) }}">
                    <i class="fas fa-fw fa-print"></i>
                    Gerar PDF Formulário
                </a>
                @endif
                @if($processo->descricao_processo=="GPS")
                <a class="btn btn-danger" href="{{ route('gerarPdfgps', ['id' => $processo->idForm,'idp' => $processo->id]) }}">
                    <i class="fas fa-fw fa-print"></i>
                    Gerar PDF Formulário
                </a>
                @endif
                @if($processo->descricao_processo=="TIC") 
                <a class="btn btn-danger" href="{{ route('gerarPdftic', ['id' => $processo->idForm,'idp' => $processo->id]) }}">
                    <i class="fas fa-fw fa-print"></i>
                    Gerar PDF Formulário
                </a>
                @endif 
            @elseif($processo->num_duc=="")

                @if(count($listaProcessosPendentes) > 1) 
                    <a class="btn btn-success" data-toggle="modal" data-target="#gerarducmultiplo">
                        <i class="fas fa-fw fa-book"></i>
                        Gerar DUC Múltiplo
                    </a>
                @else
                    <a class="btn btn-success" data-toggle="modal" data-target="#gerarduc">
                        <i class="fas fa-fw fa-book"></i>
                        Gerar DUC
                    </a>
                @endif 
            @endif
            @if($processo->estadoP=="PENDENTE PAGAMENTO") 
                @if(count($listaProcessosParaenviarDuc) > 1) 
                    <a class="btn btn-info" data-toggle="modal" data-target="#enviarEmailDuc">
                        <i class="fas fa-fw fa-envelope"></i>
                        Enviar DUC Múltiplo
                    </a> 
                @else
                    <a class="btn btn-info" data-toggle="modal" data-target="#enviarEmailDuc">
                        <i class="fas fa-fw fa-envelope"></i>
                        Enviar DUC
                    </a> 
                @endif  
            @endif   
        @endcan 

        <!-- PERMISSAO PARA GERAR PROCESSO AUTOMATICO ---> 
        @can('gerir-processo')
            @if($processo->estadoD=="PENDENTE PAGAMENTO" && $processo->estadoP=="DUC ENVIADO" && $processo->p_urgente==0)
                <a class="btn btn-danger" data-toggle="modal" data-target="#processoUrgente">
                <i class="fas fa-fw fa-star"></i>
                Este Processo é urgente?
                </a>
            @elseif($processo->estadoD=="PAGO" && $processo->estadoP=="DUC ENVIADO" || $processo->estadoP=="DUC ENVIADO" && $processo->p_urgente==1)
                @if($processo->descricao_processo=="CCTV" || $processo->descricao_processo=="Biometria" ) 
                    <a class="btn btn-primary" data-toggle="modal" data-target="#autorizacaoAuto">
                        <i class="fas fa-fw fa-file"></i>
                        Gerar Autorização
                    </a>
                    <div id="autorizacaoAuto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title">
                                    Emissão de {{$processo->tipo_processo}} - {{$processo->entidade}} 
                                    </h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <form class="was-validated" method="post"
                                        action="{{ route('gerarAutomatico', ['id' => $processo->id]) }}"
                                        enctype="multipart/form-data">
                                        @csrf  
                                        <p> 
                                            @if($notificacao)
                                                    @foreach($notificacao as $notif)
                                                    
                                                        <br> 
                                                    <div>
                                                            @if($processo->descricao_processo=="CCTV")
                                                                <p id="paragrafo">
                                                                    <b>{{ $notif['nome_denominacao'] }}</b>, notificou à <b>Comissão Nacional de Protecção de Dados (CNPD)</b> um tratamento de dados pessoais
                                                                    resultante do sistema de videovigilância, com finalidade de <b>proteção de pessoas e bens</b> a realizar 
                                                                    @if($processo->tipo_entidade=="Particular") 
                                                                        na sua residência,
                                                                    @else
                                                                    no seu estabelecimento
                                                                    @endif
                                                                    sita em {{ $notif['local_responsavel_tratamento'] }}, Cidade da {{ $notif['local_responsavel_tratamento'] }},
                                                                    ilha de {{ $notif['ilha_responsavel_tratamento'] }}.
                                                                </p>
                                                                <p id="paragrafo">
                                                                    @if($notif['entidade_processamento_informacao']=="")
                                                                        O sistema, cuja responsabilidade de processamento da informação é do(a) próprio(a) notificante,
                                                                    @else
                                                                        O sistema, cuja responsabilidade de processamento da informação é da entidade <b>{{ $notif['entidade_processamento_informacao'] }}</b>,
                                                                    @endif 
                                                                
                                                                    @php
                                                                        $formatter = new NumberFormatter('pt_PT', NumberFormatter::SPELLOUT);
                                                                    @endphp
                                                                    dispõe de  <b>{{ $notif['numero_camaras'] }} ({{ $formatter->format($notif['numero_camaras'])}}) câmaras</b>,
                                                                    abrangendo as seguintes áreas: 
                                                                   <!-- @if($notif['zonas_abrangidas']!="")
                                                                        @if ($notif['tipo_cctv'] == 'Formulário geral de videovigilância')
                                                                        <b>{{$notif['zonas_abrangidas']}}</b>,
                                                                        @else
                                                                            @foreach ($notif['zonas_abrangidas'] as $zona)
                                                                            <b>{{$zona}}</b>,
                                                                            @endforeach
                                                                        @endif
                                                                    @endif -->
                                                                    @if($notif['zonas_abrangidas']!="")
                                                                        @if ($notif['tipo_cctv'] == 'Formulário geral de videovigilância')
                                                                            <b>{{$notif['zonas_abrangidas']}}</b>
                                                                        @else
                                                                            @foreach ($notif['zonas_abrangidas'] as $index => $zona)
                                                                                <b>{{$zona}}</b>@if ($index < count($notif['zonas_abrangidas']) - 1), @endif
                                                                                @if ($index == count($notif['zonas_abrangidas']) - 1).@endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endif

                                                                </p>
                                                                <p id="paragrafo">
                                                                    @if($notif['local_transmissao_imagens']!="")
                                                                        Há visualização das imagens em tempo real.
                                                                    @else
                                                                        Não há visualização das imagens em tempo real.
                                                                    @endif
                                                                </p>
                                                                <p id="paragrafo">
                                                                    @if($notif['quem_tem_acesso_imagens']!="")
                                                                        Há transmissão de imagens para fora do local de instalação.
                                                                    @else
                                                                        Não há transmissão de imagens para fora do local de instalação.
                                                                    @endif
                                                                </p> 
                                                                <p id="paragrafo">
                                                                    Os titulares dos dados podem exercer o direito de acesso de forma 
                                                                    @if ($notif['forma_direito_acesso'])
                                                                        @foreach ($notif['forma_direito_acesso'] as $forma)
                                                                        {{ $forma }},
                                                                        @endforeach
                                                                    @endif
                                                                    junto do(a) notificante.
                                                                </p>
                                                                <p id="paragrafo">
                                                                    @if ($notif['parecer_representante_trabalhadores'])
                                                                        Existe representante dos trabalhadores.
                                                                    @else
                                                                        Não existe representante dos trabalhadores.
                                                                    @endif
                                                                </p>
                                                                <p id="paragrafo">
                                                                    @if ($notif['medidas_fisicas_seguranca']!="" || $notif['medidas_logicas_seguranca']!="")  
                                                                        Foram adotadas medidas de segurança no sistema.
                                                                    @else
                                                                        Não foram adotadas medidas de segurança.
                                                                    @endif
                                                                </p> 
                                                            @elseif($processo->descricao_processo=="Biometria")

                                                            <p id="paragrafo">
                                                                <b>{{ $notif['nome_denominacao'] }}</b>, notificou à  <b>Comissão Nacional de Protecção de Dados (CNPD)</b> 
                                                                o tratamento de dados biométricos dos seus trabalhadores,
                                                                tendo como finalidade o 
                                                                    @foreach ($notif['finalidade_tratamento'] as $finalidade)
                                                                        <b>{{ $finalidade }},</b>
                                                                    @endforeach 
                                                                a realizar no seu estabelecimento, 
                                                                situado em {{ $notif['local_responsavel_tratamento'] }}, Cidade da {{ $notif['local_responsavel_tratamento'] }},
                                                                    ilha de {{ $notif['ilha_responsavel_tratamento'] }}.
                                                            </p>

                                                            <p id="paragrafo">
                                                                O tratamento notificado processa os dados relativos ao 
                                                                @foreach ($notif['dados_registrados'] as $dadosRecolhidos)
                                                                    <b>{{ $dadosRecolhidos }},</b>
                                                                @endforeach
                                                            </p>

                                                            <p id="paragrafo">
                                                                Os Dados recolhidos estão armazenados no
                                                                @foreach ($notif['forma_registro'] as $formaRegisto)
                                                                    <b>{{ $formaRegisto }},</b>
                                                                @endforeach 
                                                                e o tratamento é feito numa <b>{{$notif['forma_tratamento_informacao']}}</b>,
                                                                e diariamente, os colaboradores fazem o registo biométrico de 
                                                                @foreach ($notif['finalidade_tratamento'] as $finalidade)
                                                                    <b>{{ $finalidade }}</b>,
                                                                @endforeach. 
                                                            </p>

                                                            <p id="paragrafo">
                                                                O processamento das informações é da responsabilidade
                                                                @if($notif['entidade_processamento_informacao']=="")
                                                                do(a) próprio(a) notificante.
                                                                @else
                                                                O processamento das informações é da responsabilidade da entidade <b>{{ $notif['entidade_processamento_informacao'] }}.</b>
                                                                @endif 
                                                            </p>
                                                            
                                                            <p id="paragrafo">
                                                            Os trabalhadores, titulares dos dados, podem exercer o direito de acesso de forma 
                                                                @if ($notif['forma_direito_acesso'])
                                                                    @foreach ($notif['forma_direito_acesso'] as $forma)
                                                                    {{ $forma }},
                                                                    @endforeach
                                                                @endif
                                                                junto do(a) notificante.
                                                            </p>
                                                            <p id="paragrafo">
                                                                @if ($notif['parecer_representante_trabalhadores'])
                                                                    Existe representante dos trabalhadores.
                                                                @else
                                                                    Não existe representante dos trabalhadores.
                                                                @endif
                                                            </p> 
                                                            <p id="paragrafo">
                                                            O sistema biométrico abrange  
                                                            @php
                                                                $formatter = new NumberFormatter('pt_PT', NumberFormatter::SPELLOUT);
                                                            @endphp
                                                            <b>{{ $notif['numero_funcionarios'] }} ({{ $formatter->format($notif['numero_funcionarios'])}})</b>
                                                            trabalhadores.
                                                            </p>

                                                            <p id="paragrafo">
                                                                @if ($notif['medidade_seguranca_fisica']!="" || $notif['medidas_seguranca_logica']!="")  
                                                                    Foram adotadas medidas de segurança no sistema.
                                                                @else
                                                                    Não foram adotadas medidas de segurança.
                                                                @endif
                                                            </p> 

                                                            @endif
                                                    </div>
                                                    @endforeach
                                            @endif
                                        </p>  
                                        <hr> 
                                        <div id="modal-footer">
                                            <button type="submit" class="btn btn-success"> <i class="fas fa-fw fa-print"></i>
                                                Gerar Autorização
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($processo->descricao_processo=="CCTV" || $processo->descricao_processo=="Biometria" || $processo->descricao_processo=="TIC")

                    <a class="btn btn-danger" data-toggle="modal" data-target="#atribuirProcessosInformaticos">
                    <i class="fas fa-fw fa-share"></i>
                    Atribuir aos Técnicos Informáticos
                    </a>
                @elseif($processo->descricao_processo=="GPS" || $processo->descricao_processo=="Interconexao" || $processo->descricao_processo=="Geral")
                    <a class="btn btn-danger" data-toggle="modal" data-target="#atribuirProcessosJuridicos">
                    <i class="fas fa-fw fa-share"></i>
                    Atribuir aos Técnicos Jurídicos
                    </a>
                @endif
                <a class="btn btn-success" data-toggle="modal" data-target="#atribuirProcessosMembros">
                    <i class="fas fa-fw fa-share"></i>
                    Atribuir Processo aos Membros
                </a>  
                <div id="atribuirProcessosMembros" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="my-modal-title">Atribuir Processo aos Membros</h5>
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body"> 
                                    <div class="col-md-12"><br></div>
                                    <p id="addon-wrapping"> Selecione o Membro a atribuir o Processo</p> 
                                    <hr> 
                                    <form class="was-validated" method="post"
                                        action="{{ route('atribuirProcessoMembros', ['id' => $processo->id]) }}"
                                        enctype="multipart/form-data">
                                        @csrf  
                                        <div class="row row-cols-1">
                                            <div class="col">  
                                                <select name="relator" id="relator" class="form-control"
                                                    aria-label="Default select example" required>
                                                    <option value="">- Escolha o Membro a atribuir este Processo -</option>
                                                    @foreach($getMembros as $getMembro) 
                                                        <option value="{{ $getMembro['name']}}">{{ $getMembro['name']}}</option>
                                                    @endforeach  
                                                </select>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div> 
                                    
                                        <div class="modal-footer"> 
                                            <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-book"></i> Atribuir Processo</button>
                                        </div> 
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>  
            @endif

            @if($processo->estadoP=="PROCESSO APROVADO")
                @if(count($notaMultiplas) > 1) 
                    <a class="btn btn-primary" href="{{ route('gerarNota', ['idp' => $processo->id]) }}">
                        <i class="fas fa-fw fa-print"></i>
                        Gerar Nota Despacho Múltiplo
                    </a>
                @else
                    <a class="btn btn-primary" href="{{ route('gerarNota', ['idp' => $processo->id]) }}">
                        <i class="fas fa-fw fa-print"></i>
                        Gerar Nota Despacho
                    </a>
                @endif
            @endif
            @if($processo->estadoP=="CONCLUIDO") 
                <a class="btn btn-primary" href="{{ route('enviarNotaAuto', ['idp' => $processo->id]) }}">
                    <i class="fas fa-fw fa-print"></i>
                    Enviar Decisão e Nota Despacho
                </a> 
            @endif

            
        @endcan

        <!-- BOTOES DE ACCOES A REALIZAR PELOS TECNICOS OU PELOS MEMBROS-->
        @if($processo->estadoP=="EM ANÁLISE PELO TÉCNICO" && $processo->responsavel_processo==Auth::user()->name)
             
             @if($processo->descricao_processo=="CCTV")<!-- || $processo->descricao_processo=="Biometria"-->
                @if(!$getIdInspecao > 0)
                    <a class="btn btn-danger" data-toggle="modal" data-target="#agendarInspecao">
                        <i class="fas fa-fw fa-calendar"></i>
                        Realizar Inspeção
                    </a>
                @endif
                <a class="btn btn-info" data-toggle="modal" data-target="#anexarAuto">
                    <i class="fas fa-fw fa-upload"></i>
                    @if($processo->tipo_processo=="Autorizacao")
                        Anexar Autorização
                    @elseif($processo->tipo_processo=="Registo")
                        Anexar Registo
                    @endif 
                </a> 
            @else
                <a class="btn btn-info" data-toggle="modal" data-target="#anexarAuto">
                    <i class="fas fa-fw fa-upload"></i>
                    @if($processo->tipo_processo=="Autorizacao")
                        Anexar Autorização
                    @elseif($processo->tipo_processo=="Registo")
                        Anexar Registo
                    @endif 
                </a>
            @endif 
            <div id="agendarInspecao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="my-modal-title">Agendar Inspeção junto do(a) {{$processo->entidade}}</h5>
                            <button class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>  
                        <div class="modal-body"> 
                                <div class="col-md-12"><br></div>  
                                <form class="was-validated" method="post"
                                    action="{{ route('realizarInspecoes', ['id' => $processo->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf 
                                    @if($processo->descricao_processo=="CCTV")  
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <input class="form-control" type="text" value="{{$processo->entidade}}" name="entidade" required>  
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div> 
                                        <div class="col-md-12"><br></div>  
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">  
                                                <span class="input-group-text" id="addon-wrapping">Data:</span>
                                                    <input class="form-control" type="date" name="created_at" required>  
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-2">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">  
                                                <span class="input-group-text" id="addon-wrapping">Hora início:</span>
                                                    <input class="form-control" type="time" name="horai" required>  
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div> 
                                            <div class="col">
                                                <div class="input-group flex-nowrap">  
                                                <span class="input-group-text" id="addon-wrapping">Hora término:</span>
                                                    <input class="form-control" type="time" name="horaf" required>  
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Recebidos por: " class="form-control" name="receb_por_funcao" id="receb_por_funcao" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-2">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <input placeholder="Local da instalação onde foi realizada a inspeção ... " class="form-control" type="text" name="local" required>  
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div> 
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <input placeholder="N.º de câmaras... " class="form-control" type="number" name="num_camara" required>  
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="As câmaras estão funcionais?" class="form-control" name="cam_funcio" id="cam_funcio" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Quais são as zonas abrangidas pelas câmaras?" class="form-control" name="localiz_cam" id="localiz_cam" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Acesso às imagens. Quem acede às imagens em tempo real?" class="form-control" name="quem_visualtemp" id="quem_visualtemp" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Existe transmissão das imagens para o exterior do estabelecimento?" class="form-control" name="transm_fora" id="transm_fora" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Existe captação de som?" class="form-control" name="som" id="som" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Existe algum modelo de aviso afixado?" class="form-control" name="aviso" id="aviso" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Qual o tempo de conservação dos dados recolhidos?" class="form-control" name="tempo_conserv" id="tempo_conserv" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Existe medidas de segurança física?" class="form-control" name="serv_grav" id="serv_grav" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Existe medidas de segurança lógica?" class="form-control" name="medid_log" id="medid_log" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Existe alguma entidade externa encarregada de processar os dados?" class="form-control" name="entidd_extern" id="entidd_extern" required rows="2"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div>  
                                        <div class="col-md-12"><br></div>
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap">   
                                                    <textarea placeholder="Existe mais informações que gostarias de anotar no relatório?" class="form-control" name="mais_obs" id="mais_obs" rows="4"></textarea> 
                                                </div>
                                                <div class="valid-feedback"></div> 
                                            </div>
                                        </div> 
                                        <input class="form-control" type="hidden" name="finalidade" value="Protecao de Pessoas e Bens">   
                                        
                                    @elseif($processo->descricao_processo=="Biometria")
                                        
                                    @endif
                                    <input class="form-control" type="hidden" name="tipo_insp" value="{{$processo->descricao_processo}}"> 
                                    <input class="form-control" type="hidden" name="id_processo" value="{{$processo->id_processo}}"> 
                                    <div class="modal-footer"> 
                                        <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-save"></i> Submeter dados</button>
                                    </div> 
                                </form>
                        </div>
                    </div>
                </div>
            </div> 
        @endif
        @if($processo->estadoP=="EM ANÁLISE PELO MEMBRO" && $processo->responsavel_processo==Auth::user()->name)
            <a class="btn btn-info" data-toggle="modal" data-target="#anexarAuto">
                <i class="fas fa-fw fa-upload"></i>
                @if($processo->tipo_processo=="Autorizacao")
                    Anexar Autorização
                @elseif($processo->tipo_processo=="Registo")
                    Anexar Registo
                @endif 
            </a>
        @endif
        <!-- BOTOES DE ACCOES A REALIZAR PELOS TECNICOS OU PELOS MEMBROS-->
        @if($processo->estadoP=="AUTORIZAÇÃO EMITIDA PELO TÉCNICO" && $processo->responsavel_processo==Auth::user()->name
        || $processo->estadoP=="AUTORIZAÇÃO EMITIDA PELO MEMBRO" && $processo->responsavel_processo==Auth::user()->name) 
            <a class="btn btn-primary" data-toggle="modal" data-target="#notificarSec">
                <i class="fas fa-fw fa-check"></i>
                Notificar Secretário
            </a> 
            <div id="notificarSec" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="my-modal-title">Notificar Secretário</h5>
                            <button class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form class="was-validated" method="post"
                                action="{{ route('notificarSecretario', ['id' => $processo->id]) }}"
                                enctype="multipart/form-data">
                                @csrf 
                                <div class="col-md-12"><br></div>
                                <span class="input-group-text" id="addon-wrapping">
                                    <p id="purgente"> 
                                    Este processo já está pronto para ser aprovado?<br>
                                    </p>  
                                </span> 
                                <hr> 
                                <div id="modal-footer">
                                    <button type="submit" class="btn btn-danger"> <i class="fas fa-fw fa-check"></i>
                                        Confirmado
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
  
        <div id="anexarAuto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Anexar documento de Autorização/Registo</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>  
                    <div class="modal-body"> 
                            <div class="col-md-12"><br></div> 
                            <hr>  
                            <form class="was-validated" method="post"
                                action="{{ route('anexarAuto', ['id' => $processo->id]) }}"
                                enctype="multipart/form-data">
                                @csrf    
                                <div class="row row-cols-1"> 
                                    <div class="col">  
                                        <input accept=".doc, .docx"  type="file" name="fileAuto" id="fileAuto" class="form-control" required> 
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Campo obrigatório.</div>
                                    </div>
                                </div>
                            
                                <div class="modal-footer"> 
                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-upload"></i> Submeter Anexo </button>
                                </div> 
                            </form>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    <!-- ALERTAS COM OS ESTADOS DO PROCESSO CONFORME O ESTADO NA DATABASE -->
    @if($processo->estadoP=="Novo")
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-info" style="text-align: center">
                <strong> PROCESSO CRIADO. AGUARDANDO EMISSÃO DE DUC.</strong>
            </div>
        </div>
    @elseif($processo->estadoP=="PENDENTE PAGAMENTO")
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-danger" style="text-align: center">
                <strong> PROCESSO PENDENTE PAGAMENTO.</strong>
            </div>
        </div>
        
    @elseif($processo->estadoP=="DUC ENVIADO")
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-info" style="text-align: center">
                <strong> DUC ENVIADO AO NOTIFICANTE. AGUARDANDO PAGAMENTO.</strong>
            </div>
        </div>  
    @elseif($processo->estadoP=="PAGO")
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> PROCESSO PAGO.</strong>
            </div>
        </div> 
    @elseif($processo->estadoP=="EM ANÁLISE PELO TÉCNICO")
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-info" style="text-align: center">
                <strong> PROCESSO EM ANÁLISE PELO TÉCNICO - {{$processo->responsavel_processo}}.</strong>
            </div>
        </div>  
    @elseif($processo->estadoP=="EM ANÁLISE PELO MEMBRO")
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-info" style="text-align: center">
                <strong> PROCESSO EM ANÁLISE PELO MEMBRO - {{$processo->responsavel_processo}}.</strong>
            </div>
        </div> 
    @elseif($processo->estadoP=="AUTORIZAÇÃO EMITIDA PELO TÉCNICO")
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> AUTORIZAÇÃO EMITIDA PELO TÉCNICO - {{$processo->responsavel_processo}}.</strong>
            </div>
        </div> 
    @elseif($processo->estadoP=="AUTORIZAÇÃO EMITIDA PELO MEMBRO")
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> AUTORIZAÇÃO EMITIDA PELO MEMBRO - {{$processo->responsavel_processo}}.</strong>
            </div>
        </div> 
    @elseif($processo->estadoP=="REGISTO EMITIDO PELO TÉCNICO")
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> REGISTO EMITIDO PELO TÉCNICO - {{$processo->responsavel_processo}}.</strong>
            </div>
        </div> 
    @elseif($processo->estadoP=="REGISTO EMITIDO PELO MEMBRO")
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> REGISTO EMITIDO PELO MEMBRO - {{$processo->responsavel_processo}}.</strong>
            </div>
        </div> 
    @elseif($processo->estadoP=="AGUARDANDO APROVAÇÃO") 
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> AUTORIZAÇÃO EMITIDA, AGUARDANDO APROVAÇÃO.</strong>
            </div>
        </div> 
    @elseif($processo->estadoP=="AGUARDANDO APRECIAÇÃO") 
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> REUNIÃO AGENDADA, AGUARDANDO APRECIAÇÃO DO PROCESSO.</strong>
            </div>
        </div>
    @elseif($processo->estadoP=="PROCESSO APROVADO") 
        
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> PROCESSO APROVADO AGUARDANDO EMISSÃO NOTA DESPACHO.</strong>
            </div>
        </div> 
    @elseif($processo->estadoP=="CONCLUIDO")
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> PROCESSO CONCLUIDO, AGUARDANDO ENVIO DA AUTORIZAÇÃO AO NOTIFICANTE.</strong>
            </div>
        </div>                                            
    @endif
    @if($processo->estadoP=="EM OBSERVAÇÃO")
        <div class="col-md-12" id="centerStyle">
            <div class="alert alert-info" style="text-align: center">
                <strong> PROCESSO EM OBSERVAÇÃO, POR ALGUM MOTIVO.</strong>
            </div>
        </div>                                            
    @endif
    
    <!-- DIV DO VIEW SHOW -->
    <div class="row" id="geral">
        <div class="col-md-12" id="cabecalho">
            <b> {{ $processo->titulo }}</b>
        </div>
        <div class="table-responsive">
            <div class="col-md-12" style="border-style: ridge;border-radius: 10px;">

                <div class="box">
                    <div class="box-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab"
                                    aria-controls="info" aria-selected="true"><i class="fa fa-fw fa-info"> </i> Informações
                                    do Processo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="workflow-tab" data-toggle="tab" href="#workflow" role="tab"
                                    aria-controls="workflow" aria-selected="false"><i class="fa fa-fw fa-cogs"> </i>
                                    Worflow</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Esquema-tab" data-toggle="tab" href="#Esquema" role="tab"
                                    aria-controls="Esquema" aria-selected="false"><i class="fas fa-solid fa-chart-pie"> </i>
                                    Esquema Cronológico</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Doc-tab" data-toggle="tab" href="#Doc" role="tab"
                                    aria-controls="Doc" aria-selected="false"><i class="fa fa-fw fa-file"> </i>
                                    Documentação</a>
                            </li>  
                            <li class="nav-item">
                                <a class="nav-link" id="Observ-tab" data-toggle="tab" href="#Observ" role="tab"
                                    aria-controls="Observ" aria-selected="false"><i class="fa fa-fw fa-comments"> </i>
                                    Observações</a> 
                            </li> 
                        </ul> 
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                                <table class="table table-bordered" id="addon-wrapping">
                                    <tbody>
                                        <tr>
                                            <th style="width: 20%;">Nº de Processo</th>
                                            <th>{{ $processo->num_processo }}</th>
                                        </tr>

                                        <tr>
                                            <td>Nº DUC</td>
                                            <th> {{ $processo->num_duc }} </th>
                                        </tr>
                                        <tr>
                                            <td>Estado DUC</td>
                                            <th>
                                            @if($processo->estadoD=="") 
                                                <label class="badge badge-danger">Sem DUC</label>
                                            @elseif($processo->estadoD=="Novo") 
                                                <label class="badge badge-primary">{{ $processo->estadoD}}</label>
                                            @elseif($processo->estadoD=="PENDENTE PAGAMENTO") 
                                                <label class="badge badge-danger">{{ $processo->estadoD}}</label>
                                            @elseif($processo->estadoD=="PAGO")  
                                                <label class="badge badge-success">{{ $processo->estadoD}}</label>
                                            @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Estado Processo</td>
                                            <th> 
                                            @if($processo->estadoP=="Novo") 
                                                <label class="badge badge-primary">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="PENDENTE PAGAMENTO") 
                                                <label class="badge badge-danger">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="DUC ENVIADO")  
                                                <label class="badge badge-warning">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="PAGO")  
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="EM ANÁLISE PELO TÉCNICO")  
                                                <label class="badge badge-info">{{ $processo->estadoP}} - {{$processo->responsavel_processo}}</label>
                                            @elseif($processo->estadoP=="EM ANÁLISE PELO MEMBRO")  
                                                <label class="badge badge-info">{{ $processo->estadoP}} - {{$processo->responsavel_processo}}</label>
                                            @elseif($processo->estadoP=="AGUARDANDO APROVA  ")  
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="AUTORIZAÇÃO EMITIDA PELO TÉCNICO")
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="AUTORIZAÇÃO EMITIDA PELO MEMBRO")
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="REGISTO EMITIDO PELO TÉCNICO")
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="REGISTO EMITIDO PELO MEMBRO")
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="AGUARDANDO APROVAÇÃO")
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="AGUARDANDO APRECIAÇÃO")
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="PROCESSO APROVADO")
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="CONCLUIDO")
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @elseif($processo->estadoP=="ARQUIVADO")
                                                <label class="badge badge-success">{{ $processo->estadoP}}</label>
                                            @endif 

                                            @if($processo->estadoP=="EM OBSERVAÇÃO")
                                                <label class="badge badge-info">{{ $processo->estadoP}}</label>
                                            @endif

                                            
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Tipo Notificação</td>
                                            <th>{{ $processo->descricao_processo }}</th>
                                        </tr>
                                        <tr>
                                            <td>Nome Denominação</td>
                                            <th>{{ $processo->entidade }}</th>
                                        </tr>
                                        <tr>
                                            <td>Tipo Processo</td>
                                            <th>{{ $processo->tipo_processo }}</th>
                                        </tr>
                                        <tr>
                                            <td>Data Entrada</td>
                                            <th>{{ $processo->created_at }}</th>
                                        </tr>
                                        <tr>
                                        </tr>
                                        <tr>
                                            <td>Preço Unitario</td>
                                            <th>{{ $processo->preco_pago }}</th>
                                        </tr>
                                        <tr>
                                            <td>Nome(s) Relator(es)</td>
                                            <th> {{ $processo->responsavel_processo }} </th>
                                        </tr>



                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="workflow" role="tabpanel" aria-labelledby="workflow-tab">
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12" id="cabecalho">
                                    <b> Logs do Processo - {{$processo->num_processo}}</b>
                                </div>
                                <div class="col-md-12"><br></div> 
                                <table class="display dataTable cell-border" id="nhatabela" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th style="width: 20%;">Utilizador</th>
                                            <th>Ação</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($listarLogs)
                                            @foreach ($listarLogs as $logg)
                                                <tr>  
                                                    <td>{{$logg->user_name}} </td>
                                                    <td>{{$logg->action}}</td>
                                                    <td>{{$logg->created_at}}</td>
                                                    
                                                </tr>
                                            @endforeach
                                        @endif 
                                    </tbody> 
                                </table> 
                                
                            </div>    
                            <div class="tab-pane fade" id="Esquema" role="tabpanel" aria-labelledby="Esquema-tab">
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12" id="cabecalho">
                                    Esquema Cronológico do Processo {{$processo->num_processo}}
                                </div>  
                                <div class="col-md-12"><br></div> 

                                <!-- ESQUEMA CRONOLOGICO DO PROCESSO-->
                                @if($processo->estadoP=="Novo")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:20%" id="abaixo50"> 20% - {{$processo->estadoP}}</div>
                                </div>
                                @elseif($processo->estadoP=="PENDENTE PAGAMENTO")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:25%" id="abaixo50"> 25% - {{$processo->estadoP}}</div>
                                </div>
                                @elseif($processo->estadoP=="DUC ENVIADO")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:40%" id="abaixo50"> 30% - {{$processo->estadoP}}</div>
                                </div> 
                                @elseif($processo->estadoP=="PAGO")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:40%" id="abaixo50"> 40% - {{$processo->estadoP}}</div>
                                </div>  
                                @elseif($processo->estadoP=="EM ANÁLISE PELO TÉCNICO")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:50%" id="abaixo50"> 50% - {{$processo->estadoP}}</div>
                                </div>   
                                @elseif($processo->estadoP=="EM ANÁLISE PELO MEMBRO")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:50%" id="abaixo50"> 50% - {{$processo->estadoP}}</div>
                                </div> 
                                @elseif($processo->estadoP=="AUTORIZAÇÃO EMITIDA PELO TÉCNICO")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:60%" id="acima50"> 60% - {{$processo->estadoP}}</div>
                                </div> 
                                @elseif($processo->estadoP=="AUTORIZAÇÃO EMITIDA PELO MEMBRO")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:60%" id="acima50"> 60% - {{$processo->estadoP}}</div>
                                </div> 
                                @elseif($processo->estadoP=="REGISTO EMITIDO PELO TÉCNICO")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:60%" id="acima50"> 60% - {{$processo->estadoP}}</div>
                                </div>  
                                @elseif($processo->estadoP=="REGISTO EMITIDO PELO MEMBRO")
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:60%" id="acima50"> 60% - {{$processo->estadoP}}</div>
                                </div>  
                                @elseif($processo->estadoP=="AGUARDANDO APROVAÇÃO") 
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:70%" id="acima50"> 70% - {{$processo->estadoP}}</div>
                                </div> 
                                @elseif($processo->estadoP=="AGUARDANDO APRECIAÇÃO") 
                                    <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:75%" id="acima50"> 75% - {{$processo->estadoP}}</div>
                                    </div>  
                                @elseif($processo->estadoP=="PROCESSO APROVADO") 
                                    <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:80%" id="acima50"> 80% - {{$processo->estadoP}}</div>
                                    </div>  
                                @elseif($processo->estadoP=="CONCLUIDO") 
                                    <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:90%" id="acima50"> 90% - {{$processo->estadoP}}</div>
                                    </div> 
                                @elseif($processo->estadoP=="ARQUIVADO") 
                                    <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%" id="acima50"> 100% - {{$processo->estadoP}}</div>
                                    </div>  
                                @endif    
                                @if($processo->estadoP=="EM OBSERVAÇÃO") 
                                    <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width:100%" id="acima50"> 90% - {{$processo->estadoP}}</div>
                                    </div>  
                                @endif   
 
                                <div class="col-md-12"><br></div> 
                                
                            </div>
                            <div class="tab-pane fade" id="Doc" role="tabpanel" aria-labelledby="Doc-tab">
                                <div class="col-md-12"> <br> </div>
                                <p id="right"> 
                                    @if($processo->estadoP!="Concluido")  
                                        <a class="btn btn-primary" data-toggle="modal" data-target="#submeterNovoDoc">
                                            <i class="fas fa-fw fa-file"></i>
                                            Submeter Documentos
                                        </a>
                                    @endif 
                                </p>
                                <div class="col-md-12"> <br> </div>
                                <div class="col-md-12" id="cabecalho">
                                    Documentos relacionados ao Formulário
                                </div>
                                <div class="col-md-12"> <br> </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if($processo->anexo_forms!="")
                                            <a href="" data-toggle="modal" data-target="#verFormulario">
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title"> <b> Visualizar Formulário</b></h5>
                                                        <div class="col-md-12"> <br> </div>
                                                        <div class="col-md-12"> <br> </div>
                                                        <img src="{{ url("images/form.png")}}" id="fotoFile">
                                                    </div>
                                                </div>
                                            </a>
                                            @endif
                                        </div>
                                         
                                            @if($processo->descricao_processo!="Interconexao")
                                                @if($notificacao)
                                                    @foreach($notificacao as $notific)
                                                        @if($notific['parecer_representante_trabalhadores']!="")
                                                            <div class="col-md-3">
                                                                <a href="" data-toggle="modal" data-target="#verParecerTrabalhador">
                                                                    <div class="card mb-3">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title"> <b> Visualizar Representante dos
                                                                                    Trabalhadores</b></h5>
                                                                            <div class="col-md-12"> <br> </div>
                                                                            <img src="{{ url("images/colaborador.png")}}" id="fotoFile">
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div> 
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <div id="verParecerTrabalhador" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="my-modal-title">Visualizar Parecer de Trabalhadores</h5>
                                                                <button class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row row-cols-1">
                                                                    @if($notific['parecer_representante_trabalhadores']!=null)
                                                                    <embed
                                                                        src="{{ url("storage/parecerTrabalhadores/{$notific['parecer_representante_trabalhadores']}")}}"
                                                                        width="100%" height="650px" line-height: 0;></embed>
                                                                    @endif
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        
                                        @if($processo->descricao_processo=="Biometria")
                                            <div class="col-md-3"> 
                                                <a href="" data-toggle="modal" data-target="#vercatalogoEquipamento">
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <h5 class="card-title"> <b> Visualizar Catálogo de Equipamento</b></h5>
                                                            <div class="col-md-12"> <br> </div>
                                                            <img src="{{ url("images/file.png")}}" id="fotoFile">
                                                        </div>
                                                    </div>
                                                </a> 
                                            </div> 
                                            <div id="vercatalogoEquipamento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="my-modal-title">Visualizar Catálogo de Equipamento</h5>
                                                            <button class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row row-cols-1">
                                                                @if($notific['catalago_equipamento']!=null)
                                                                <embed
                                                                    src="{{ url("storage/catalagoEquipamento/{$notific['catalago_equipamento']}")}}"
                                                                    width="100%" height="650px" line-height: 0;></embed>
                                                                @endif 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        @endif
                                        <div class="col-md-3">
                                            @if($processo->num_duc!="")
                                            <a href="" data-toggle="modal" data-target="#verDuc">
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title"> <b> Visualizar DUC</b></h5>
                                                        <div class="col-md-12"> <br> </div>
                                                        <div class="col-md-12"> <br> </div>
                                                        <img src="{{ url("images/duc.png")}}" id="fotoFile">
                                                    </div>
                                                </div>
                                            </a>
                                            @endif
                                        </div> 
                                        @if($autorizacao) 
                                            @foreach($autorizacao as $auto)
                                                @if($auto['anexo'] && Str::endsWith($auto['anexo'], '.docx')) 
                                                    <div class="col-md-3"> 
                                                        <a href="{{ url('autos/' . $auto['anexo']) }}" target="selfe">
                                                            <div class="card mb-3">
                                                                <div class="card-body">
                                                                    <h5 class="card-title"> 
                                                                    @if($processo->tipo_processo=="Autorizacao") 
                                                                    <b> Abrir Autorização no Word</b>
                                                                    @else 
                                                                    <b> Abrir Registo no Word</b>
                                                                    @endif 
                                                                    </h5>
                                                                    <div class="col-md-12"> <br> </div>
                                                                    <img src="{{ url("images/auto.png")}}" id="fotoFile">
                                                                </div>
                                                            </div>
                                                        </a>    
                                                    </div>
                                                @else
                                                    <div class="col-md-3"> 
                                                        <a href="" data-toggle="modal" data-target="#verAutoReg">
                                                            <div class="card mb-3">
                                                                <div class="card-body">
                                                                    <h5 class="card-title"> 
                                                                     <b>Visualizar decisão </b>
                                                                    </h5> 
                                                                    <div class="col-md-12"> <br>  </div>
                                                                    <p><br></p>
                                                                    <img src="{{ url("images/auto.png")}}" id="fotoFile"> 
                                                                </div>
                                                            </div>
                                                        </a> 
                                                    </div> 
                                                @endif
                                            @endforeach 
                                        @endif  
                                        @if(!$inspecoes->isEmpty())
                                            <div class="col-md-3"> 
                                                <a href="" data-toggle="modal" data-target="#verRel">
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <h5 class="card-title"> <b> Visualizar Relatório Inspeção</b></h5>
                                                            <div class="col-md-12"> <br> </div>
                                                            <img src="{{ url("images/relatorios.png")}}" id="fotoFile">
                                                        </div>
                                                    </div>
                                                </a> 
                                            </div>   
                                            <div id="verRel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="my-modal-title">Visualizar relatório</h5>
                                                            <button class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row row-cols-1">
                                                                @foreach($inspecoes as $inspec)
                                                                    <embed src="{{ url("inspecoesProcesso/{$inspec['anexo_rel']}")}}" width="100%" height="650px"
                                                                        line-height: 0;>
                                                                    </embed>  
                                                                @endforeach
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif  
                                        @if($processo->anexo_notadesp!="")
                                            <div class="col-md-3"> 
                                                <a href="" data-toggle="modal" data-target="#verNota">
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <h5 class="card-title"> <b> Visualizar Nota Despacho </b></h5>
                                                            <div class="col-md-12"> <br> </div>
                                                            <img src="{{ url("images/nota.png")}}" id="fotoFile">
                                                        </div>
                                                    </div>
                                                </a> 
                                            </div>   
                                            <div id="verNota" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="my-modal-title">Visualizar Nota Despacho</h5>
                                                            <button class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row row-cols-1"> 
                                                                <embed src="{{ url("notas/{$processo->anexo_notadesp}")}}" width="100%" height="650px"
                                                                    line-height: 0;>
                                                                </embed>   
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        @endif 
                                        @if($processo->qrcode!="")
                                            <div class="col-md-3"> 
                                                <a href="" data-toggle="modal" data-target="#verQrCode">
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <h5 class="card-title"> <b> Visualizar QR CODE </b></h5>
                                                            <div class="col-md-12"> <br> </div>
                                                            <img src="{{ url("qrcodes/{$processo->qrcode}")}}" id="fotoFile">
                                                        </div>
                                                    </div>
                                                </a> 
                                            </div>   
                                            <div id="verQrCode" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="my-modal-title">Visualizar  QR CODE</h5>
                                                            <button class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row row-cols-1"> 
                                                            <embed src="{{ url("qrcodes/{$processo->aviso}")}}" width="100%" height="650px" style="line-height: 0;"></embed>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        @endif 
                                    </div>
                                </div>
                                <div class="col-md-12"> <br> </div>
                                <div class="col-md-12" id="cabecalho">
                                    Documentos anexados
                                </div>
                                <div class="col-md-12"> <br> </div>
                                <div class="container">
                                    @if($docProcesso)
                                    <div class="row">
                                        @foreach($docProcesso as $docProc)
                                        <div class="col-md-3">
                                            <a href="" data-toggle="modal" data-target="#verdocs{{$docProc['id']}}">
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title"> <b> {{$docProc['name']}}</b></h5>
                                                        <div class="col-md-12"> <br> </div>
                                                        <img src="{{ url("images/file.png")}}" id="fotoFile">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div id="verdocs{{$docProc['id']}}" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="my-modal-title" aria-hidden="true" style="z-index: 12000000;">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="my-modal-title">Visualizar Documento
                                                        </h5>
                                                        <button class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row row-cols-1">
                                                            <embed src="{{ url("storage/processos/{$docProc['file']}")}}"
                                                                width="100%" height="650px" line-height: 0;></embed>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-12"> <br> </div>
                                <div class="col-md-12" id="cabecalho">
                                    Documentos do despacho Final
                                </div>
                                <div class="col-md-12"> <br> </div>
                                <div class="container">
 
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Observ" role="tabpanel" aria-labelledby="Observ-tab">
                                <br>
                                <div class="col-md-12" id="cabecalho">
                                    Observações do Processo - {{ $processo->num_processo }}
                                </div> 
                                @if($processo->responsavel_processo==Auth::user()->name)
                                    <p id="right">
                                        <a class="btn btn-primary" data-toggle="modal" data-target="#fazerComments">
                                            <i class="fas fa-fw fa-comment"></i>
                                            Observações
                                        </a>
                                    </p> 
                                @endif
                                @can('fullMenu')
                                    <p id="right"> 
                                        @if($processo->estadoP!="Concluido")  
                                            <a class="btn btn-primary" data-toggle="modal" data-target="#fazerComments">
                                                <i class="fas fa-fw fa-comment"></i>
                                                Observaçõesssss
                                            </a> 
                                        @endif 
                                    </p> 
                                @endcan 
                                <table class="display dataTable cell-border" id="nhatabela1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th style="width: 20%;">Utilizador - Função</th>
                                            <th>Observação</th>
                                            <th>Data Comentário</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($listarComments)
                                            @foreach($listarComments as $comment)
                                                <tr>  
                                                    <td>{{$comment->name}} - {{$comment->typeUser}}</td>
                                                    <td>{{$comment->comments}}</td>
                                                    <td>{{$comment->created_at}}</td> 
                                                </tr>
                                            @endforeach
                                        @endif 
                                    </tbody> 
                                </table>  
                            </div>  
                            </div>
                        </div> 
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->

    <div id="verDuc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Visualizar DUC</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-cols-1"> 
                        <embed id="pdf-embed" src="{{ $caminho }}" width="100%" height="650px" line-height: 0;></embed>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="processoUrgente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Quer marcar esse Processo como urgente?</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form class="was-validated" method="post"
                        action="{{ route('processoUrgente', ['id' => $processo->id]) }}"
                        enctype="multipart/form-data">
                        @csrf 
                        <div class="col-md-12"><br></div>
                        <span class="input-group-text" id="addon-wrapping">
                            <p id="purgente"> 
                            Se marcar esse Processo como urgente <br> os próximos trâmites serão seguidos normalmente. <br>
                            mesmo que o pagamento não seja feito. <br>
                            </p>  
                        </span> 
                        <hr> 
                        <div id="modal-footer">
                            <button type="submit" class="btn btn-danger"> <i class="fas fa-fw fa-star"></i>
                                Confirmar Processo Urgente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="verFormulario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Visualizar Formulário</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-cols-1">
                        <embed src="{{ url("storage/formularios/{$processo->anexo_forms}")}}" width="100%" height="650px"
                            line-height: 0;></embed>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="verAutoReg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Visualizar autorização / Registo</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-cols-1">
                        @if($autorizacao) 
                            @foreach($autorizacao as $auto) 
                                <embed src="{{ url("autos/{$auto['anexo']}")}}" width="100%" height="650px"
                                    line-height: 0;>
                                </embed> 
                            @endforeach 
                        @endif 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="submeterNovoDoc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Submeter Documento</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" method="post" action="{{ route('submeterDoc', ['id' => $processo->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input class="form-control" type="hidden"  value="{{$processo->id}}"
                                        placeholder="{{$processo->id}}" name="idProcesso">
                                </div>
                                <div class="valid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12"> <br> </div>
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input class="form-control" type="text" required placeholder="Nome do anexo"
                                        name="name">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>
                        <div class="col-md-12"> <br> </div>
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input class="form-control" type="file" required placeholder="Nome do anexo"
                                        name="fileDoc">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>
                        <hr>

                        <div id="modal-footer">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-upload"></i>
                                Submeter Documento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="fazerComments" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Fazer observação</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" method="post" action="{{ route('fazerObservacao', ['id' => $processo->id]) }}"
                        enctype="multipart/form-data">
                        @csrf  
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <textarea class="form-control" type="text" rows="4" required placeholder="Faça a sua observação nesse processo ..." name="comments"></textarea>
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div> 
                        <hr>

                        <div id="modal-footer">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-comment"></i>
                                Salvar observação</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="gerarduc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Gerar DUC - {{$processo->entidade}}</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" method="post"
                        action="{{ route('gerarDuc', ['id' => $processo->idForm,'idp' => $processo->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <span class="input-group-text" id="addon-wrapping">
                            @foreach($listaProcessosParaenviarDuc as $listaProcessoParaenviarDuc)
                                    Notificação Tratamento de Dados de {{ $listaProcessoParaenviarDuc->descricao_processo }} - {{$listaProcessoParaenviarDuc->preco_pago}} $00<br> 
                            @endforeach 
                        </span> 
                        
                        <div class="col-md-12"><br></div>
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input class="form-control" type="text" required 
                                    placeholder="Descrição do DUC cobrado. Ex: Taxa Notificação de Videovigilância" name="p_obs">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div> 
                        <div class="col-md-12"><br></div> 
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap"> 
                                <span class="input-group-text" id="addon-wrapping">NIF</span>
                                    <input class="form-control" type="number" 
                                    @if($notificacao)
                                        @foreach($notificacao as $notific)
                                            value="{{$notific['numero_nif']}}"
                                        @endforeach
                                    @endif
                                    required placeholder="Nif do cliente a cobrar. Ex: 123456789"
                                        name="p_nif">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div> 
                        <div class="col-md-12"><br></div>  
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap"> 
                                <span class="input-group-text" id="addon-wrapping">VALOR</span>
                                    <input class="form-control" disabled type="number"  
                                        value="{{$processo->preco_pago}}" 
                                    required placeholder="Valor a cobrar do cliente. Ex: 5.000 $00"
                                    name="p_valor" id="p_valor">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div> 
                        <div class="col-md-12"><br></div> 
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap" disabled>
                                <span class="input-group-text" id="addon-wrapping">EMAIL</span>
                                <input class="form-control" type="email"  
                                value="celina.cruz@mf.gov.cv" disabled required name="p_email">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>  
                        <div class="col-md-12"><br></div> 
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap" disabled>
                                <span class="input-group-text" id="addon-wrapping">Moeda</span>
                                <input class="form-control" type="text" value="CVE" required placeholder="Moeda" name="p_moeda">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div> 
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input class="form-control" type="hidden" value="223"  required placeholder="Código instituição"
                                        name="p_recebedoria">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>  
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input class="form-control" type="hidden" value="MCAII01" placeholder="Código de Transação"
                                        name="p_codTransacao">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>  
                        <hr>

                        <div id="modal-footer">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-save"></i>
                                Gerar DUC</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="gerarducmultiplo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Gerar DUC Múltiplo da Entidade: {{ $processo->entidade }}</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" method="post"
                        action="{{ route('gerarDucMultiplo', ['id' => $processo->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <label>Processos a cobrar DUC</label>   

                        <span class="input-group-text" id="addon-wrapping">
                            @foreach($listaProcessosPendentes as $listaProcessoPen)
                                    Notificação Tratamento de Dados de {{ $listaProcessoPen->descricao_processo }} - {{$listaProcessoPen->preco_pago}} $00<br> 
                            @endforeach 
                        </span>  
                        <div class="col-md-12"><br></div>
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <textarea class="form-control" rows="4" required 
                                    placeholder="Descrição do DUC cobrado. Ex: 2 Taxa Notificação de Videovigilância, ..." 
                                    name="p_obs"></textarea>
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>
                        
                        <?php $valortotal = 0;
                            foreach($listaProcessosPendentes as $listaProcessoPen){
                                $valortotal += $listaProcessoPen->preco_pago;
                            }  
                        ?>   
                        <div class="col-md-12"><br></div>
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">  
                                    <span class="input-group-text" id="addon-wrapping">$00</span>
                                    <input class="form-control" type="number"  
                                    value="{{$valortotal}}"   
                                    required 
                                    placeholder="Valor total do DUC. Ex: 10.000"
                                    name="p_valor"> 
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div> 
                        <div class="col-md-12"><br></div>
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap"> 
                                <span class="input-group-text" id="addon-wrapping">NIF</span>
                                    <input class="form-control" type="number" 
                                    @if($notificacao)
                                        @foreach($notificacao as $notific)
                                            value="{{$notific['numero_nif']}}"
                                        @endforeach
                                    @endif
                                    required placeholder="Nif do cliente a cobrar. Ex: 123456789"
                                        name="p_nif">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>

                        <div class="col-md-12"><br></div>
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap" disabled> 
                                <span class="input-group-text" id="addon-wrapping">Moeda</span>
                                    <input class="form-control" type="text" value="CVE" required placeholder="Moeda" name="p_moeda">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div> 
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input class="form-control" type="hidden" value="223"  required placeholder="Código instituição"
                                        name="p_recebedoria">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div> 
                        <div class="col-md-12"><br></div> 
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap" disabled>
                                <span class="input-group-text" id="addon-wrapping">EMAIL</span>
                                <input class="form-control" type="email"  
                                value="celina.cruz@mf.gov.cv" disabled required name="p_email">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>  
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input class="form-control" type="hidden" value="MCAII01" required placeholder="Código de Transação"
                                        name="p_codTransacao">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>  
                        <hr>

                        <div id="modal-footer">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-save"></i>
                                Gerar DUC Múltiplo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="enviarEmailDuc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Enviar DUC da Entidade: {{ $processo->entidade }}</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" method="post"
                        action="{{ route('sendDucEmail', ['id' => $processo->id]) }}"
                        enctype="multipart/form-data">
                        @csrf 

                        <span class="input-group-text" id="addon-wrapping">
                            @foreach($listaProcessosParaenviarDuc as $listaProcessoParaenviarDuc)
                                    Notificação Tratamento de Dados de {{ $listaProcessoParaenviarDuc->descricao_processo }},<br> 
                            @endforeach 
                        </span>    
                        <div class="col-md-12"><br></div>   
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">  
                                <span class="input-group-text" id="addon-wrapping">Email da entidade</span>
                                    <input class="form-control" type="text" 
                                    @if($notificacao)
                                        @foreach($notificacao as $notific)
                                            value="{{$notific['email_responsavel_tratamento']}}" 
                                        @endforeach
                                    @endif
                                    required  name="email">  
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>
                        <div class="col-md-12"><br></div>  
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">  
                                <span class="input-group-text" id="addon-wrapping">Email em CC:</span>
                                    <input class="form-control" type="text" placeholder="Insira outro email no conhecimento" name="emailCC">  
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>
                        <div class="col-md-12"><br></div>  
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">  
                                <span class="input-group-text" id="addon-wrapping">Assunto</span>
                                    <input class="form-control" type="text"  
                                    @foreach($notificacao as $notific)
                                            value="Envio de DUC - CNPD" 
                                        @endforeach
                                    required name="assunto">  
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>
                        <div class="col-md-12"><br></div>
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap"> 
                                    <input class="form-control" rows="10"
                                    value="Para efetuar o pagamento do DUC queira entrar nesse link: https://www.mf.gov.cv/web/mf/pagamento-duc e siga os trâmites para o pagamento do DUC. Ou dirija-se a uma das agéncias dos Bancos Comerciais e efetue o pagamento do DUC." 
                                    placeholder="Corpo do email ..." 
                                    name="conteudo">
                                </div>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div> 
                        <div class="col-md-12"><br></div>
                        
                        <hr>

                        <div id="modal-footer">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-envelope"></i>
                                Enviar DUC</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="atribuirProcessosInformaticos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Atribuir Processo aos Técnicos Informáticos</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> 
                        <div class="col-md-12"><br></div>
                        <label for=""> Selecione o Técnico a atribuir o Processo</label> 
                        <hr> 
                        <form class="was-validated" method="post"
                            action="{{ route('atribuirProcessoTecnicos', ['id' => $processo->id]) }}"
                            enctype="multipart/form-data">
                            @csrf  
                            <div class="row row-cols-1">
                                <div class="col">  
                                    <select name="relator" id="relator" class="form-control"
                                        aria-label="Default select example" required>
                                        <option value="">- Escolha o técnico a atribuir este Processo -</option>
                                        @foreach($getTecnicosInf as $getTecnicoInf) 
                                            <option value="{{ $getTecnicoInf['name']}}">{{ $getTecnicoInf['name']}}</option>
                                        @endforeach  
                                    </select>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Campo obrigatório.</div>
                                </div>
                            </div>  
                            <div class="modal-footer"> 
                                <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-book"></i> Atribuir Processo</button>
                            </div> 
                        </form>
                </div>
            </div>
        </div>
    </div> 
    <div id="atribuirProcessosJuridicos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-atribuir-titulo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-atribuir-titulo">Atribuir Processo aos Técnicos Jurídicos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div id="conteudo-modal">
                    <label for=""> Selecione o Técnico a atribuir o Processo</label>
                </div>
                <form class="was-validated" method="post"
                    action="{{ route('atribuirProcessoTecnicos', ['id' => $processo->id]) }}"
                    enctype="multipart/form-data">
                    @csrf 
                    <div class="col-md-12"><br></div> 
                    <div class="row row-cols-1">
                        <div class="col">  
                            <select name="relator" id="relator" class="form-control"
                                aria-label="Default select example" required>
                                <option value="">- Escolha o técnico a atribuir este Processo -</option>
                                @foreach($getTecnicosJur as $getTecnicoJur) 
                                    <option value="{{ $getTecnicoJur['name']}}">{{ $getTecnicoJur['name']}}</option>
                                @endforeach  
                            </select>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Campo obrigatório.</div>
                        </div>
                    </div>  
                    <div class="modal-footer"> 
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-book"></i> Atribuir Processo</button>
                    </div>
                </form>                        
            </div>
        </div>
    </div>
 
 


@else
<!-- Breadcrumbs -->

{{ Breadcrumbs::render('Processos') }}
<div class="col-md-12" id="notFound">
    <br>
    <p>ID não encontrado.</p>
</div>


@endif
<style> 
    .progress{
    height: 40px;
    }
    #acima50{ 
        background-color: green;
    }
    #abaixo50{ 
        background-color: red;
    }
    #alerta{ 
        font-weight: bold;
    }
    #centerStyle{
        text-align: center
    }
    #addon-wrapping{
        text-align: left;
    }

    #paragrafo{
        text-align: justify;
        text-justify: inter-word;
        font-family: 'Times New Roman', Times, serif;
        color:black;
    }
    #purgente {
        font-weight: bold;
        text-align: center;
    }
    #fazerComments,
    #verRel,
    #notificarSec,
    #autorizacaoAuto,
    #verAutoReg,
    #anexarAuto,
    #verNota,
    #agendarInspecao,
    #atribuirProcessosJuridicos,
    #atribuirProcessosInformaticos, 
    #atribuirProcessosMembros,
    #gerarduc,
    #submeterNovoDoc,
    #verDuc,
    #verParecerTrabalhador,
    #verFormulario,
    #gerarducmultiplo,
    #processoUrgente,
    #enviarEmailDuc,
    #verQrCode {
        z-index: 12000000;
    }

    #fotoFile {
        width: 35%;
    }

    .card {
        text-align: center
    }

    a:hover {
        color: #000;
        text-decoration: none;
    }

    table,
    th,
    td {
        border: 1px solid black;
        font-family: 'Times New Roman', Times, serif;
        color: #000
    }

    #modal-body {
        color: #061536;
        font-family: 'Times New Roman', Times, serif;
    }

    .modal-title,
    label {
        color: #061536;
        font-weight: bold;
    }

    #notFound {
        color: #ffffff;
        border-style: ridge;
        border-radius: 10px;
        background-color: #990000;
        text-align: center;
    }

    #geral {
        font-size: 14px;
        background-color: #fff;
        color: #061536;
        font-family: "Times New Roman", Times, serif;
        margin-left: 5px;
        margin-right: 10px
    }

    .nova {
        margin-bottom: 10px;
        margin-right: 20px;
        text-align: right;
    }

    #cabecalho {
        color: #ffffff;
        border-style: ridge;
        border-radius: 10px;
        text-align: center;
        background: #051636;
    }

    #name {
        font-weight: bold;
        color: #061536;
    }

    #nameCenter {
        text-align: center;
    }

    #right {
        text-align: right;
    }

    #descricao {
        color: #061536;
        border-style: ridge;
    }

    #col {
        color: #061536;
        font-weight: bold;
        text-align: center;
    }

    #modal-footer {
        text-align: center;
    }


    .box-body {
        font-size: 15px
    }

    .nav-item {
        font-weight: bold;
    }

    .nav-item:hover {
        color: white;
    }
</style> 
 
   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
        crossorigin="anonymous">
</script> 
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js">
</script> 
<script src="https://code.jquery.com/jquery-3.5.1.js">
</script> 


<script src="https://code.jquery.com/jquery-3.6.3.min.js" 
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" 
    crossorigin="anonymous">
</script>
<script src="{{ asset('admin/js/Datatable.js') }}"></script> 
    <script>
         
      let table = new DataTable('#nhatabela'); 
      let table1 = new DataTable('#nhatabela1'); 
         
      setTimeout(function(){
        $(".alert:not(.alert-fixed)").slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000)
    </script>
 
@endsection