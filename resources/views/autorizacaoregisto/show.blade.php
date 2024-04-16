@extends('layouts.master')
@section('title', 'Ver Autorização')
@section('content')
 
@if($autoid)
<!-- Breadcrumbs -->
{{ Breadcrumbs::render('Ver Autorização', $autoid) }}
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

 

<!-- DIV DO VIEW SHOW -->
<div class="row" id="geral">
    <div class="col-md-12" id="cabecalho">
        <b> {{ $autoid->entidade }}</b>
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
                                        <th style="width: 20%;">Nº de Decisão</th>
                                        <th>{{ $autoid->num_decisao }}</th>
                                    </tr>

                                    <tr>
                                        <td>Data Emissão</td>
                                        <th>{{ $autoid->created_at }}</th>
                                    </tr>

                                    <tr>
                                        <td>Entidade</td>
                                        <th> {{ $autoid->entidade }} </th>
                                    </tr>
                                    <tr>
                                        <td>Nº. Processo</td>
                                        <th> 
                                           <a id="colorLink" href="{{ url('/processos/' .  $autoid->idProcesso ) }}"> {{ $autoid->idProcesso }} - Ver Processo</a>
                                        </th>
                                    </tr> 
                                    <tr>
                                        <td>Data Decisão</td>
                                        <th>{{ $autoid->data_decisao }}</th>
                                    </tr>
                                    <tr>
                                        <td>Estado</td>
                                        <th id="colorLink">{{ $autoid->estado }}</th>
                                    </tr>   
                                    <tr>
                                        <td>Anexo Decisão</td>
                                        <th> 
                                            <div class="col-md-3"> 
                                                @if($autoid->anexo && Str::endsWith($autoid->anexo, '.docx')) 
                                                        <a href="{{ url('autos/' . $autoid->anexo) }}" target="selfe">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">  
                                                                        <b> Abrir Decisão no Word</b>  
                                                                    </h5>
                                                                    <div class="col-md-12"> <br> </div>
                                                                    <img src="{{ url("images/auto.png")}}" id="fotoFile">
                                                                </div>
                                                            </div>
                                                        </a> 
                                                @else
                                                    <a href="" data-toggle="modal" data-target="#verAutoReg">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title">  
                                                                <b id="colorLink"> Visualizar Anexo</b> 
                                                                </h5> 
                                                                <img src="{{ url("images/auto.png")}}" id="fotoFile">
                                                            </div>
                                                        </div>
                                                    </a>  
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
                                                                        <embed src="{{ url("autos/{$autoid->anexo}")}}" width="100%" height="650px"
                                                                                line-height: 0;></embed> 
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                @endif 
                                            </div>
                                        </th>
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
     
    #verAutoReg {
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