<!DOCTYPE html>
 <html>
    @if($results)
        @foreach($results as $result) 
            <head> 
                <title> 
                    Nota despacho {{ $result->entidade }}  
                </title> 
            </head>
            
            <body>

                <img class="img-profile " width="60" height="40" src="admin/img/logo.png">
                <div class="col-md-12"><br></div> 
                <div class="col-md-12"><br></div> 
                
                <footer>
                    <hr>
                    <p> Contribuinte Nº: 370636406, Av. da China, Rampa da Terra Branca, Apartado 1002, C.P. 7600, Praia, Tel:
                        (238) 5340390<br>cnpd@cnpd.cv, <u style="color:blue">www.cnpd.cv</u></p> 
                </footer>
                <main>
                    <div class="row" id="geral">

                        <div class="col-md-12"><br></div> 
                        <div id="right">
                            <b>À {{$result->entidade}}</b>  
                                @if($notificacao)
                                    @foreach($notificacao as $not)
                                        <p id="right"> 
                                            {{$not->local_responsavel_tratamento}} - {{$not->ilha_responsavel_tratamento}}
                                        </p>
                                    @endforeach
                                @endif 
                            <div class="col-md-12"><br></div> 
                            
                            <p id="right">Praia, 
                                <?php
                                    setlocale(LC_TIME, 'pt_BR');
                                    $dataAtual = strftime('%d de %B de %Y');
                                    echo strtolower($dataAtual); 
                                ?>
                            </p> 
                        </div>  
                        <div class="col-md-12"><br></div> 

                        <p id="negritoLeft">N/Refª Nº. {{$result->num_notadesp}}/CNPD</p> 
                        <div class="col-md-12"><br></div> 
                        <div class="col-md-12"><br></div> 
                        <p id="paragrafo">
                            <b id="pag">Assunto: </b> Nota Despacho
                        </p> 
                            
                        <div>
                            <p id="paragrafo">
                                Por despacho da <b>Comissão Nacional de Protecção de Dados - CNPD</b>,
                                somos à notificar à <b>{{$result->entidade}}</b>, a decisão da CNPD relativamente aos Processos
                                de autorização de 

                                @if(count($notaMultiplas) > 1) 
                                    <b> Tratamento de Dados Pessoais. </b>
                                @else
                                    @if($result->descricao_processo == 'CCTV')
                                        <b> videovigilância. </b>
                                    @elseif($result->descricao_processo == 'GPS')
                                        <b> Geolocalização. </b>
                                    @elseif($result->descricao_processo == 'Interconexao')
                                        <b> Interconexão. </b>
                                    @elseif($result->descricao_processo == 'Geral')
                                        <b> Tratamento de Dados Pessoais. </b>
                                    @elseif($result->descricao_processo == 'Biometria')
                                        <b> Tratamento de Dados Biométricos. </b>
                                    @elseif($result->descricao_processo == 'TIC')
                                        <b> TIC - CONTROLO DE UTILIZAÇÃO DE TELEFONE/CORREIO ELECTRÓNICO/INTERNET. </b>
                                    @endif 
                                @endif
                                
                            </p>

                            <div class="col-md-12"><br></div> 
                            <p id="paragrafo">
                                 @if(count($notaMultiplas) > 1) 
                                 Em anexo as cópias da Autorização dos seguintes Processos do(a) <b> {{$result->entidade}}</b>: <br><br>
                                    @foreach($autos as $auto) 
                                            @if($result->tipo_processo == 'Autorizacao')
                                                <b>  Processo de Autorização</b>
                                            @elseif($result->descricao_processo == 'Registo')
                                                <b>  Processo de Registo</b> 
                                            @endif  
                                            @if($auto->descricao_processo == 'CCTV')
                                                <b> - Videovigilância Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @elseif($auto->descricao_processo == 'GPS')
                                                <b> -Geolocalização Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @elseif($auto->descricao_processo == 'Interconexao')
                                                <b> -Interconexão Nº. {{$auto->num_decisao}}/CNPD</b><br>
                                            @elseif($auto->descricao_processo == 'Geral')
                                                <b> -Tratamento de Dados Pessoais Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @elseif($auto->descricao_processo == 'Biometria')
                                                <b> -Tratamento de Dados Biométricos Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @elseif($auto->descricao_processo == 'TIC')
                                                <b> -TIC - CONTROLO DE UTILIZAÇÃO DE TELEFONE/CORREIO ELECTRÓNICO/INTERNET Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @endif  
                                    @endforeach  
                                @else
                                    Em anexo a cópia da Autorização do seguinte Processo do(a) <b> {{$result->entidade}}</b> : <br><br>
                                        @foreach($autos as $auto) 
                                            @if($result->tipo_processo == 'Autorizacao')
                                                <b>  Processo de Autorização de</b>
                                            @elseif($result->descricao_processo == 'Registo')
                                                <b>  Processo de Registo de</b> 
                                            @endif  
                                            @if($auto->descricao_processo == 'CCTV')
                                                <b> - Videovigilância Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @elseif($auto->descricao_processo == 'GPS')
                                                <b> -Geolocalização Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @elseif($auto->descricao_processo == 'Interconexao')
                                                <b> -Interconexão Nº. {{$auto->num_decisao}}/CNPD</b><br>
                                            @elseif($auto->descricao_processo == 'Geral')
                                                <b> -Tratamento de Dados Pessoais Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @elseif($auto->descricao_processo == 'Biometria')
                                                <b> -Tratamento de Dados Biométricos Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @elseif($auto->descricao_processo == 'TIC')
                                                <b> -TIC - CONTROLO DE UTILIZAÇÃO DE TELEFONE/CORREIO ELECTRÓNICO/INTERNET Nº. {{$auto->num_decisao}}/CNPD </b><br>
                                            @endif  
                                        @endforeach  
                                    
                                @endif
                            </p> 

                            <div class="col-md-12"><br></div> 
                            <div class="col-md-12"><br></div>  
                            <p id="pag">
                                <b>Com os melhores cumprimentos,</b>
                            </p> 
                            <div class="col-md-12"><br></div> 
                            <div class="col-md-12"><br></div> 
                            <div class="col-md-12"><br></div>   
                            
                            <br>
                            <p id="center">
                                <img src="{{ public_path('images/assinaturaGregs.png') }}" style="max-width: 60%; height: auto;"> 
                            </p> 
                        </div>   
                </main>
            <!-- Numeração da página -->
            
            </body>
        @endforeach
    @endif 
 </html>
 <style>
    #pupu{
        color:red
    }
    #paragrafo{
        text-align: justify;
        text-justify: inter-word;
        font-family: 'Times New Roman', Times, serif;
        color:black;
    }
    #paragrafo1{
        text-align: justify;
        text-justify: inter-word;
        font-family: 'Times New Roman', Times, serif;
        color:black;
        padding-left: 50px;
    }
    #center {
        font-weight: bold;
        text-align: center;
    }

    #negritoLeft {
        font-weight: bold;
        text-align: left;
    }

    footer {
        position: fixed;
        left: 0px;
        right: 0px;
        height: 150px;
        bottom: 0px;
        margin-bottom: -130px;
        text-align: center;
        font-size: 10px;
        color: #061536;
        font-family: "Times New Roman", Times, serif;
    }

    header {
        position: fixed;
        left: 0px;
        right: 0px;
        height: 150px;
        margin-top: -150px;
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
    #pag{
        padding-left: 50px;
    }
    #cabecalho {
        color: #ffffff;
        border-style: ridge;
        border-radius: 5px;
        background: #061536;
    }

    #name {
        font-weight: bold;
        color: #061536;
    }

    #right {
        text-align: right;
    }

    #nameCenter {
        text-align: center;
    }

    #descricao {
        color: #061536;
        border-style: ridge;
    }

    #reptrab {
        height: auto;
        z-index: 10000000;
    }

    #borderStyle {
        color: #061536;
        border-style: ridge;
    }

    td, th {
    font-weight: normal;
    }
    table {
        font-family: "Times New Roman", Times, serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        text-align: left;
        padding: 8px;
    }

    th {
        width: 40%
    }

    table,
    th,
    td {
        border: 1px solid #061536;
    }
 </style>