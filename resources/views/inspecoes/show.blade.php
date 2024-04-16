@extends('layouts.master')
@section('title', 'Ver Inspeção')
@section('content')
 
@if($inspecaoId)
<!-- Breadcrumbs -->
{{ Breadcrumbs::render('Ver Inspeção', $inspecaoId) }}
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
    @if($inspecaoId->estado=="Realizada") 
         
        <a class="btn btn-primary" data-toggle="modal" data-target="#addFotos">
            <i class="fas fa-fw fa-upload"></i>
            Adicionar Fotografias
        </a>
        <div id="addFotos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Gerar DUC</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" method="post" 
                    action="{{ route('addFotos', ['id' => $inspecaoId->id]) }}"
                        enctype="multipart/form-data">
                        @csrf   
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input class="form-control" type="file" accept="image/*" required name="anexoFoto">
                                </div>
                                <div class="va id-feedback"></div>
                                <div class="invalid-feedback">Campo obrigatório.</div>
                            </div>
                        </div>
                        <hr>

                        <div id="modal-footer">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-save"></i>
                                Add Foto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        @if(!$fotos->isEmpty())
            <a class="btn btn-danger" href="{{ route('gerarReportInsp', ['id' => $inspecaoId->id]) }}">
                <i class="fas fa-fw fa-print"></i>
                Gerar Relatório de Inspeção - PDF
            </a>
        @endif
        
    @endif
</div>

<!-- DIV DO VIEW SHOW -->
<div class="row" id="geral">
    <div class="col-md-12" id="cabecalho">
        <b>Inspecao realizada nas instalações do(a) - {{ $inspecaoId->entidade }}</b>
    </div>
    <div class="col-md-12"><br></div>
    <div class="table-responsive">
        <div class="col-md-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-6" id="info" role="tabpanel" aria-labelledby="info-tab">  
                    <label for="">Informações da Inspeção</label> 
                        <div class="col-md-6"><br></div>
                        <table class="table table-bordered" style="text-align: left;">
                            <tbody>
                                <tr>
                                    <td style="width: 20%;">Entidade</td>
                                    <th> {{ $inspecaoId->entidade }} </th>
                                </tr>

                                <tr>
                                    <td>Data Emissão</td>
                                    <th>{{ $inspecaoId->created_at }}</th>
                                </tr>

                                <tr>
                                    <td>Nº. Processo</td>
                                    <th> 
                                    <a id="colorLink" href="{{ url('/processos/' .  $inspecaoId->id_processo ) }}">  Ver Processo</a>
                                    </th>
                                </tr> 
                                <tr>
                                    <td>Inspetor</td>
                                    <th>{{ $inspecaoId->equipa_insp }}</th>
                                </tr>
                                <tr>
                                    <td>Hora início</td>
                                    <th>{{ $inspecaoId->horai }}</th>
                                </tr>
                                <tr>
                                    <td>Hota término</td>
                                    <th>{{ $inspecaoId->horaf }}</th>
                                </tr> 
                                <tr>
                                    <td>Estado</td>
                                    <th id="colorLink">{{ $inspecaoId->estado }}</th>
                                </tr>    
                                
                            </tbody>
                        </table> 
                    </div>  
                    <div class="col-md-6">
                        <div class="row"> 
                        <label for="">Fotografias da Inspeção</label> 
                        <div class="col-md-6"><br></div>
                            @foreach($fotos as $foto)
                                <div class="col-md-3"> 
                                    <a href="" data-toggle="modal" data-target="#verfoto{{$foto['id']}}">
                                        <div class="card">
                                            <div class="card-body">  
                                                <img src="{{ url("inspecoesProcesso/{$foto['anexo']}")}}" id="fotoFile1">
                                            </div>
                                        </div>
                                    </a>
                                    <div id="verfoto{{$foto['id']}}" class="modal fade" tabindex="-1" role="dialog"
                                        aria-labelledby="my-modal-title" aria-hidden="true" style="z-index: 12000000;">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="my-modal-title">Ver Anexo - {{$foto['anexo']}}
                                                    </h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row row-cols-1">
                                                        <embed src="{{ url("inspecoesProcesso/{$foto['anexo']}")}}"
                                                            width="100%" height="650px" line-height: 0;></embed>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6"><br></div>
                        <div class="col-md-6"> 
                            @if($inspecaoId->anexo_rel)  
                                <a href="" data-toggle="modal" data-target="#verRel">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">  
                                            <b id="colorLink"> Visualizar relatório</b> 
                                            </h5> 
                                            <img src="{{ url("images/relatorios.png")}}" id="fotoFile">
                                        </div>
                                    </div>
                                </a>  
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
                                                    <embed src="{{ url("inspecoesProcesso/{$inspecaoId->anexo_rel}")}}" width="100%" height="650px"
                                                        line-height: 0;>
                                                    </embed>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            @else
                            <b>Sem relatório </b>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
 
             
                    
        </div>
    </div>
</div> 


@else
<!-- Breadcrumbs -->

{{ Breadcrumbs::render('Autorização') }}
<div class="col-md-12" id="notFound">
    <br>
    <p>ID não encontrado.</p>
</div>


@endif
<style> 
    #alerta{ 
            font-weight: bold;
        }
    #colorLink{
        color:green
    }
    #fotoFile {
        width: 35%;
    }
    #fotoFile1 {
        width: 100%;
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
     
    #addFotos,#verRel {
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
<script>
setTimeout(function() {
    $(".alert").slideUp(500, function() {
        $(this).remove();
    });
    //  window.location.reload();
}, 5000);

 
 
</script>
 
@endsection