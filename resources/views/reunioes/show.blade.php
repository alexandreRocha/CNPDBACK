@extends('layouts.master')
@section('title', 'Ver Reunião')
@section('content')
 
@if($reuniao)
<!-- Breadcrumbs -->
{{ Breadcrumbs::render('Ver Reunião', $reuniao) }}
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

<div class="nova"> 
    @can('gerir-processo')
        @if($reuniao->ordem_trab=="" && $reuniao->data_reuniao!="")
            <a class="btn btn-danger" href="{{ route('ordemPdf', ['id' => $reuniao->id]) }}">
                <i class="fas fa-fw fa-print"></i>
                Gerar Ordem de Trabalho
            </a>
        @endif

        @if($reuniao->estadoR == "Finalizada" && $reuniao->anexo_ata=="")
        <a class="btn btn-danger" data-toggle="modal" data-target="#anexarAta">
            <i class="fas fa-fw fa-edit"></i>
            Anexar Ata Reunião
        </a>
        <div id="anexarAta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Anexar Ata de Reunião</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>  
                    <div class="modal-body"> 
                            <div class="col-md-12"><br></div> 
                            <hr>  
                            <form class="was-validated" method="post"
                                action="{{ route('anexarAta', ['id' => $reuniao->id]) }}"
                                enctype="multipart/form-data">
                                @csrf    
                                <div class="row row-cols-1"> 
                                    <div class="col">  
                                        <input accept=".pdf,.docx,.doc"  type="file" name="fileAta" id="fileAta" class="form-control" required> 
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Campo obrigatório.</div>
                                    </div>
                                </div>
                            
                                <div class="modal-footer"> 
                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-edit"></i> Submeter Ata </button>
                                </div> 
                            </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endcan
    @if($reuniao->data_reuniao=="")
        @if(Auth::user()->name=="Faustino Monteiro")  
            <a class="btn btn-danger" data-toggle="modal" data-target="#confirmarR">
                <i class="fas fa-fw fa-calendar"></i>
                Confirmar Reunião
            </a> 
        @endif
    @endif
</div>
 <!-- ALERTAS -->

@if($reuniao->data_reuniao!="" && $reuniao->ordem_trab=="")
    <div class="col-md-12" id="centerStyle">
            <div class="alert alert-danger" style="text-align: center">
                <strong> REUNIÃO AGENDADA, AGUARDANDO ORDEM DO DIA.</strong>
            </div>
    </div> 
@elseif($reuniao->estadoR=="Agendada" && $reuniao->data_reuniao=="")
    <div class="col-md-12" id="centerStyle">
            <div class="alert alert-warning" style="text-align: center">
                <strong> REUNIÃO AGENDADA, AGUARDANDO CONFIRMAÇÃO DO PRESIDENTE.</strong>
            </div>
    </div>
 @elseif(strtotime(date('Y-m-d')) < strtotime($reuniao->data_reuniao))
    <div class="col-md-12" id="centerStyle">
        <div class="alert alert-warning" style="text-align: center">
            <strong> REUNIÃO AGENDADA, AGUARDANDO DATA DE REUNIÃO.</strong>
        </div>
    </div>
 @elseif($reuniao->estadoR=="Finalizada")
    <div class="col-md-12" id="centerStyle">
            <div class="alert alert-info" style="text-align: center">
                <strong> REUNIÃO FINALIZADA.</strong>
            </div>
    </div>  
@elseif($reuniao->estadoR=="Confirmada")
    <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> REUNIÃO EM ANÁLISE.</strong>
            </div>
    </div>  
@elseif($reuniao->estadoR=="Encerrada")
    <div class="col-md-12" id="centerStyle">
            <div class="alert alert-success" style="text-align: center">
                <strong> REUNIÃO ENCERRADA.</strong>
            </div>
    </div>  
@endif
<!-- DIV DO VIEW SHOW -->
<div class="row" id="geral">
    <div class="col-md-12" id="cabecalho">
        <b> Reunião Nº. {{ $reuniao->num_reuniao }}</b>
    </div>
    <div class="table-responsive">
        <div class="col-md-12" style="border-style: ridge;border-radius: 10px;">

            <div class="box">
                <div class="box-body"> 

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <table class="table table-bordered" style="text-align: left;">
                                <tbody>
                                    <tr>
                                        <th  id="colorBold">Nº de Reunião</th>
                                        <th>{{ $reuniao->num_reuniao }}</th>
                                    </tr> 
                                    <tr>
                                        <td id="colorBold">Data Reunião</td>
                                        <th>{{ $reuniao->data_reuniao }}</th>
                                    </tr>
                                    <tr>
                                        <td id="colorBold">Ordem de Trabalho:</td>
                                        <th> 
                                            @if($reuniao->ordem_trab=="")
                                                <p>Aguardando Ordem de Trabalho ...</p>
                                            @else
                                                <a href="#" data-toggle="modal" data-target="#verOrdem"> 
                                                    <h8 class="card-title">  
                                                        <b id="colorLink"> <i class="fas fa-fw fa-file"></i> Ver Ordem de Trabalho</b> 
                                                    </h8> 
                                                </a>  
                                                <div id="verOrdem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h8 class="modal-title" id="my-modal-title"> Visualizar Ordem de Trabalho</h8>
                                                                <button class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row row-cols-1">
                                                                    <embed src="{{ url("reuniao/{$reuniao->ordem_trab}")}}" width="100%" height="650px"
                                                                    line-height: 0;>
                                                                    </embed>  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                            @endif 
                                        </th>
                                    </tr>  
                                    <tr>
                                        <td id="colorBold">
                                            <br><br><br><br> 
                                            Apreciação dos seguintes Processos de Autorizações: 
                                        </td>
                                        <th>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Entidade</th>
                                                    <th>Decisão</th>
                                                    <th>Acção</th>
                                                </tr>
                                                @foreach($processosSelecionados as $processPronto) 
                                                        <tr>
                                                            <td>
                                                                <a id="colorLink" href="{{ url('/processos/' . $processPronto->IDP) }}"> 
                                                                <i class="fas fa-fw fa-link"></i> {{ $processPronto->notificante }} - {{ $processPronto->tipo }}
                                                                </a>  
                                                            </td>
                                                            <td> 
                                                                @if($processPronto->anexo && Str::endsWith($processPronto->anexo, '.docx')) 
                                                                    <a href="{{ url('autos/' . $processPronto->anexo) }}" target="selfe"> 
                                                                        <h8 class="card-title">  
                                                                            <b id="colorLink"> <i class="fas fa-fw fa-file"></i> Abrir Decisão no Word</b>  
                                                                        </h8>  
                                                                    </a> 
                                                                @else
                                                                    <a href="#" data-toggle="modal" data-target="#verAutoReg{{$processPronto->IDP}}"> 
                                                                        <h8 class="card-title">  
                                                                            <b id="colorLink"> <i class="fas fa-fw fa-file"></i> Visualizar Anexo PDF</b> 
                                                                        </h8> 
                                                                    </a>  
                                                                    <div id="verAutoReg{{$processPronto->IDP}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h8 class="modal-title" id="my-modal-title">Visualizar autorização / Registo</h8>
                                                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row row-cols-1">
                                                                                        <embed src="{{ url("autos/{$processPronto->anexo}")}}" width="100%" height="650px"
                                                                                                line-height: 0;></embed> 
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                @endif 
                                                            </td>
                                                            <td> 
                                                                @if($processPronto->data_reuniao=="")
                                                                    <p>Aguardando confirmação do Presidente.</p>
                                                                @elseif($processPronto->data_reuniao!="" && $processPronto->ordem_trab=="")
                                                                    <p>Reunião Confirmada.</p>
                                                                @endif
                                                                @can('gerir-processo')
                                                                    @if($reuniao->ordem_trab!="" && date('Y-m-d') === $processPronto->data_reuniao)
                                                                        @if($processPronto->estadoRP=="Novo" && $processPronto->anexo && Str::endsWith($processPronto->anexo, '.docx'))    
                                                                            <a class="btn btn-success" data-toggle="modal" data-target="#anexarPdf">
                                                                                <i class="fas fa-fw fa-print"></i>
                                                                                Aprovar
                                                                            </a>
                                                                            <div id="anexarPdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                                                                <div class="modal-dialog modal-md" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="my-modal-title">Anexar Decisão Final PDF</h5>
                                                                                            <button class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>  
                                                                                        <div class="modal-body"> 
                                                                                                <div class="col-md-12"><br></div> 
                                                                                                <hr>  
                                                                                                <form class="was-validated" method="post"
                                                                                                    action="{{ route('aprovarWord', ['idp' => $processPronto->IDP]) }}"
                                                                                                    enctype="multipart/form-data">
                                                                                                    @csrf    
                                                                                                    <div class="row row-cols-1"> 
                                                                                                        <div class="col">  
                                                                                                            <input accept=".pdf"  type="file" name="fileAuto" id="fileAuto" class="form-control" required> 
                                                                                                            <div class="valid-feedback"></div>
                                                                                                            <div class="invalid-feedback">Campo obrigatório.</div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                
                                                                                                    <div class="modal-footer"> 
                                                                                                        <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-upload"></i> Submeter Decisão PDF </button>
                                                                                                    </div> 
                                                                                                </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <a class="btn btn-danger" data-toggle="modal" data-target="#naoaprovar{{$processPronto->IDP}}">
                                                                                <i class="fas fa-fw fa-info"></i>
                                                                                Não Aprovar
                                                                            </a>
                                                                            <div id="naoaprovar{{$processPronto->IDP}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="my-modal-title">Motivo da não aprovação deste Processo</h5>
                                                                                            <button class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>  
                                                                                        <div class="modal-body">   
                                                                                            <form class="was-validated" method="post" action="{{ route('processonaoaprovado',  ['idr' => $reuniao->id,'idp' => $processPronto->processo,'idRp' => $processPronto->idRP]) }}"
                                                                                                enctype="multipart/form-data">
                                                                                                @csrf  
                                                                                                <div class="row row-cols-1">
                                                                                                    <div class="col">
                                                                                                        <div class="input-group flex-nowrap">
                                                                                                            <textarea class="form-control" type="text" rows="4" required placeholder="Faça a observação sobre o porquê da não aprovação desse processo ..." name="obs"></textarea>
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
                                                                           
                                                                        @else 
                                                                            @if($processPronto->estadoRP == "Novo")
                                                                                <a class="btn btn-success" href="{{ route('aprovarPdf', ['idp' => $processPronto->IDP]) }}">
                                                                                    <i class="fas fa-fw fa-print"></i>
                                                                                    Aprovar
                                                                                </a>
                                                                                <a class="btn btn-danger" data-toggle="modal" data-target="#naoaprovar{{$processPronto->IDP}}">
                                                                                    <i class="fas fa-fw fa-info"></i>
                                                                                    Não Aprovar
                                                                                </a>
                                                                                <div id="naoaprovar{{$processPronto->IDP}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="my-modal-title">Motivo da não aprovação deste Processo</h5>
                                                                                            <button class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>  
                                                                                        <div class="modal-body">   
                                                                                            <form class="was-validated" method="post" action="{{ route('processonaoaprovado', ['idr' => $reuniao->id,'idp' => $processPronto->processo,'idRp' => $processPronto->idRP]) }}"
                                                                                                enctype="multipart/form-data">
                                                                                                @csrf  
                                                                                                <div class="row row-cols-1">
                                                                                                    <div class="col">
                                                                                                        <div class="input-group flex-nowrap">
                                                                                                            <textarea class="form-control" type="text" rows="4" required placeholder="Faça a observação sobre o porquê da não aprovação desse processo ..." name="obs"></textarea>
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
                                                                            @else
                                                                                <b id="colorLink"> <i class="fas fa-fw fa-check"></i> {{$processPronto->EstadoPR }}</b> 
                                                                            @endif
                                                                        @endif
                                                                    @endif  
                                                                @endcan  
                                                            </td>
                                                        </tr>  
                                                @endforeach  
                                            </table>
                                        </th>
                                    </tr> 
                                    @if($reuniao->processo_parecer)
                                        <tr>
                                            <td id="colorBold">Processos de Parecer: </td>
                                            <th >{{ $reuniao->processo_parecer }}</th>
                                        </tr>
                                    @endif 
                                    @if($reuniao->processo_queixa)
                                        <tr>
                                            <td id="colorBold">Processos de Queixa: </td>
                                            <th>{{ $reuniao->processo_queixa }}</th>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td id="colorBold">Outros Assuntos:</td>
                                        <th>{{ $reuniao->outros_assuntos }}</th>
                                    </tr>
                                    <tr>
                                        <td id="colorBold">Nº de Ata </td>
                                        <th >{{ $reuniao->num_ata }}</th>
                                    </tr> 
                                    <tr>
                                        <td id="colorBold">Anexo de Ata </td>
                                        <th> 
                                             @if($reuniao->anexo_ata!="")  
                                                @if($reuniao->anexo_ata && Str::endsWith($reuniao->anexo_ata, '.docx')) 
                                                    <a href="{{ url('atas/' . $reuniao->anexo_ata) }}" target="selfe"> 
                                                        <h8 class="card-title">  
                                                            <b id="colorLink"> <i class="fas fa-fw fa-file"></i> Abrir Ata no Word</b>  
                                                        </h8>  
                                                    </a> 
                                                @else
                                                    <a href="#" data-toggle="modal" data-target="#verAutoReg"> 
                                                        <h8 class="card-title">  
                                                            <b id="colorLink"> <i class="fas fa-fw fa-file"></i> Visualizar Ata PDF</b> 
                                                        </h8> 
                                                    </a>  
                                                    <div id="verAutoReg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h8 class="modal-title" id="my-modal-title">Visualizar Ata da Reunião</h8>
                                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row row-cols-1">
                                                                        <embed src="{{ url("atas/{$reuniao->anexo_ata}")}}" width="100%" height="650px"
                                                                                line-height: 0;></embed> 
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                             @endif
                                        </th>
                                    </tr> 
                                    <tr>
                                        <td id="colorBold">Estado</td>
                                        <th id="colorLink">{{ $reuniao->estadoR }}</th>
                                    </tr>  
                                </tbody>
                            </table>
                        </div>
                          
                         
                    </div>


                </div>
            </div>

        </div>
    </div>
</div> 
<div id="confirmarR" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title"> <b style="color:#000"> Confirmar a Reunião {{$reuniao->num_reuniao}}</b> </h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
            <div class="modal-body"> 
                <div class="col-md-12"><br></div>  
                <form class="was-validated" method="post"
                    action="{{ route('confirmarReuniao', ['id' => $reuniao->id]) }}"
                    enctype="multipart/form-data">
                    @csrf 
                    <div class="row row-cols-1">
                        <div class="col">
                            <div class="input-group flex-nowrap">  
                            <span class="input-group-text" id="addon-wrapping">Data Reunião:</span>
                                <input class="form-control" type="date" name="data_reuniao" required>  
                            </div>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Campo obrigatório.</div>
                        </div>
                    </div>
                    <div class="col-md-12"><br></div>
                    <div class="row row-cols-1">
                        <div class="col">
                            <div class="input-group flex-nowrap">  
                            <span class="input-group-text" id="addon-wrapping">Hora início:</span>
                                <input class="form-control" type="time" name="hora_reuniao" required>  
                            </div>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Campo obrigatório.</div>
                        </div>  
                    </div> 
                        <div class="modal-footer"> 
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-save"></i> Submeter dados</button>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div> 


@else
<!-- Breadcrumbs -->

{{ Breadcrumbs::render('Reuniões') }}
<div class="col-md-12" id="notFound">
    <br>
    <p>ID não encontrado.</p>
</div>


@endif
<style> 
    #alerta,#colorBold,#colorLink{ 
            font-weight: bold;
    }
    #colorLink{
        color:green
    }
     
    #fotoFile {
        width:15%;
    }
    #paragrafo{
        text-align: justify;
        text-justify: inter-word;
        font-family: 'Times New Roman', Times, serif;
        color:black;
    }
     
     
    #verAutoReg,#anexarAta,#anexarPdf,#verAutoReg,#confirmarR,#verOrdem {
        z-index: 12000000;
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

    

    #right {
        text-align: right;
    }

    #descricao {
        color: #061536;
        border-style: ridge;
    }

    #col {
        color: #061536; 
        text-align: center;
    }

    #modal-footer {
        text-align: center;
    }


    .box-body {
        font-size: 15px
    }

    #centerStyle{
        text-align: center
    }

    #anexarAta,#verAutoReg,#naoaprovar, #anexarPdf{

        z-index: 12000000;
    }
     
     h5{
        font-weight:bold;
        color:black;

     }
</style>
<script>
setTimeout(function() {
    $(".alert").slideUp(500, function() {
        $(this).remove();
    });
    //  window.location.reload();
}, 5000);

 
 
</script>
 
@endsection